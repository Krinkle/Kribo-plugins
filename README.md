[![Build Status](https://travis-ci.org/Krinkle/Kribo-plugins.svg?branch=master)](https://travis-ci.org/Krinkle/Kribo-plugins)

# Kribo plugins

## Installation

After you have installed [Kribo](https://github.com/Krinkle/Kribo). You can install any plugins you like.

Eventually all that matters is that it is `require_once` included from your Kribo `./LocalConfig.php` file. Here is the easiest way to do it if you're using plugins from this repository

1. Browse to the directory where you manage your bot(s). This would be the parent directory of where you have installed Kribo.
   <br>`cd ~/bots`
1. Check out the Kribo-plugins repository
   <br>`git clone https://github.com/Krinkle/Kribo-plugins.git`
1. Let's install wmfDbBot_KriboBridge as example
 1. Browse to the plugins directory of your Kribo install:
    <br>`cd Kribo/plugins`
 1. Create a symlink from the directory in the plugins repository to here:
    <br>`ln -s ../../Kribo-plugins/wmfDbBot_KriboBridge wmfDbBot_KriboBridge`
 1. Now edit your Kribo's `./LocalConfig.php` file and add:
    <br>`require_once( $KriboDir . '/plugins/wmfDbBot_KriboBridge/wmfDbBot_KriboBridge.php' );`
