<?php
require_once 'model/Clan.php';
require_once 'model/Player.php';
require_once 'model/Category.php';
require_once 'dao/ClanDao.php';
require_once 'dao/PlayerDAO.php';
require_once 'dao/CategoryDAO.php';

$clan = ClanDAO::getClanById(1);
$players = PlayerDAO::getPlayersByClanId($clan->getId());
//$players =  PlayerDAO::getPlayersByClanId($clan->getId());


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="sass/style.css">
    <script type="text/javascript" src="node_modules/jquery/dist/jquery.slim.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <title>Towerlands Clan Scoreboard</title>
</head>
<body>
<div>
    <h1><?= $clan->getName()?></h1>
    <h2>Players (<span class="emphasis"><?= sizeof($players) ?></span>)</h2>
    <ul class="clanPlayers">
        <?php
        foreach ($players as $player) { ?>
        <li class="player">
            <div class="avatar"></div>
            <div class="title">
                <div class="playerName"><?= $player->getName()?></div>
                <div class="playerTowerLevel"><?= $player->getTowerLevel()?></div>
            </div>
            <div class="specs">
                <div class="spec">
                    <div class="label">Member since</div>
                    <div class="playerClanJoinDate">
                        <span class="emphasis"><?= (new DateTime('now'))->diff($player->getClanJoinDate())->format("%a")?></span> days
                    </div>
                </div>
                <div class="spec">
                    <div class="label">Category</div>
                    <div class="playerCategory <?=strtolower((CategoryDAO::getCategoryById($player->getCategoryId()))->getName())?>"><?= (CategoryDAO::getCategoryById($player->getCategoryId()))->getName()?></div>
                </div>
            </div>
            <div class="rank">
                <div class="spec">
                    <div class="label">Rank</div>
                    <div class="playerRank"># <span class="emphasis"><?= $player->getRank()?></span></div>
                </div>
            </div>


        <?php

        }
        ?>
    </ul>
</div>

</body>
</html>
