<?php

/**
 * This acts as a bridge between an irc bot (in this case Kribo)
 * and the wmfDbBot backend.
 */

/**
 * Load the wmfDbBot backend
 * -------------------------------------------------
 */
require_once( __DIR__ . '/wmfDbBot/InitBot.php' );

/**
 * Bridge class
 * -------------------------------------------------
 */
class wmfDbBot_KriboBridge {

	public static function cmdInfo( $data, $irc ) {
		return Commands::getInfo( $data['parsedCommand']['parts'] );
	}

	public static function cmdReplag( $data, $irc ) {
		return Commands::getReplag( $data['parsedCommand']['parts'] );
	}

	public static function cmdExternals( $data, $irc ) {
		if ( !isset( $data['parsedCommand']['parts'][0] ) ) {
			return Commands::getExternals( $data['parsedCommand']['parts'] );
		}
		if ( trim( $data['parsedCommand']['parts'][0] ) !== 'update' ) {
			return 'Invalid argument for externals.';
		}
		if ( !kfIsIrcDataSenderTrusted( $data ) ) {
			$irc->sendPrivmsg( 'Updating externals is restricted to users on the whitelist.', $data['parsedLine']['senderNick'] );
			return false;
		}

		$irc->sendPrivmsg( 'Running ./maintenance/updateExternals.php in the background..', $data['parsedLine']['senderNick'] );
		$response = Commands::purgeExternals( $data['parsedCommand']['parts'] );

		if ( isset( $response['priv'] )  ) {
			$irc->sendPrivmsg( $response['priv'], $data['parsedLine']['senderNick'] );
		}
		return $response['pub'];
	}

	public static function cmdDocs( $data, $irc ) {
		return "https://github.com/Krinkle/ts-krinkle-wmfDbBot";
	}

}

/**
 * Extend Kribo's command registry
 * -------------------------------------------------
 */

// @info
$KriboConfig->commandRegistry['info'] = array(
	'callback' => array( 'wmfDbBot_KriboBridge', 'cmdInfo' ),
	'sendResponse' => KRIBO_CMD_RE_CHANNEL_AT, // Listen only in channel with '@' prefix
);

// @replag
$KriboConfig->commandRegistry['replag'] = array(
	'callback' => array( 'wmfDbBot_KriboBridge', 'cmdReplag' ),
	'sendResponse' => KRIBO_CMD_RE_CHANNEL_AT,
);

// @externals
$KriboConfig->commandRegistry['externals'] = array(
	'callback' => array( 'wmfDbBot_KriboBridge', 'cmdExternals' ),
	'sendResponse' => KRIBO_CMD_RE_CHANNEL_AT,
);

// @help
$KriboConfig->commandRegistry['docs'] = array(
	'callback' => array( 'wmfDbBot_KriboBridge', 'cmdDocs' ),
	'sendResponse' => KRIBO_CMD_RE_CHANNEL_AT,
);
