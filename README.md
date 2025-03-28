# Popcorn: Lofi Bets ![Version 1.0.0](https://img.shields.io/badge/Version-1.0.0-0099ff)

Popcorn is a betting game written in PHP, which relies on a [Simple Machines Forum](https://www.simplemachines.org/) database to handle its operators' accounts. It allows any admin of that forum to create, modify, and resolve any hypothetical betting topic, with issue categories of administration, conflict, economics, sports, and a more important-looking "sapphire" category. Any operator can bet on those topics to see how high they can get their account to score.

## Usage
Every player starts with twenty-five thousand Refugia planets (the in-game currency). An operator can bet up to all of their planets on one issue, or spread them out more generally. However, an operator is always allowed to place at least a five thousand planet bet so that they can participate in any issue. In other words, they are allowed to plunge themselves into debt without any kind of statutory maximum, or try to claw out of debt if they have nothing.

Beyond the player account creation generating 25,000 planets, money is also added to the game whenever a topic is created. For every betting option that an issue has, a bet is automatically placed for 1,000 from the system itself. This means a three-option issue will always have a minimum payout of 3,000 planets, split between the winning players.

All issues have a ending timestamp, whereafter they are moved to a pending state, waiting for an admin to arrive and act as the Arbiter of Truth. As the Arbiter of Truth, an admin can set one of the betting options as the canonical outcome, and distribute payments according to how much the player contributed to the pool against other winners. If no betting option was correct, the admin can also abort the bet and refund anyone who staked in-game money on it.

Every current and past issue, along with their outcomes are posted to the records page which operators can consult at any time.

**The official Popcorn website is here: https://pop.calref.ca/**

## Installation and Configuration

- Minumum PHP Version: 8.0

1. Clone the repository into the directory of your choosing, or download the repository and upload/extract it to where it will be run.

2. If CURL is not bundled in your PHP install, you will need to get it for your version number. On Debian/Ubuntu, you can grab this with `sudo apt install php8.2-curl` or whatever version of php you installed. Also you may need to get the PDO drivers with `sudo apt install php8.2-sqlite`.

3. Set the directory to you local [SMF SSI](https://wiki.simplemachines.org/smf/SSI_FAQ_Basic) location (along with any optional webhook URLs you want) in the top few lines of `Public/index.php`

4. Configure your web server software to Popcorn's `Public` directory. A sample config for Apache2 includes, but is not limited to, the following:

```
<VirtualHost example.org:80>

        ServerName example.org
        ServerAdmin beans@example.org
        DocumentRoot /your/popcorn/path/Public
        FallbackResource /index.php

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
```

5. Set ownership of the pop directory to `www-data:www-data` so that PHP has write access over its database. You can do this with `sudo chown -R www-data:www-data /your/popcorn/path`