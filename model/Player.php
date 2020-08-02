<?php


class Player
{
    private $id;
    private $name;
    private $towerLevel;
    private $clanId;
    private $clanJoinDate;
    private $clanJoinTowerLevel; // Added join level for further use, 02.08.2020, RoFe
    private $categoryId;
    private $score;
    private $rank;

    /**
     * Player constructor.
     * @param $id
     * @param $name
     * @param $towerLevel
     * @param $clanId
     * @param $clanJoinDate
     * @param $clanJoinTowerLevel
     * @param $categoryId
     * @param $score
     * @param $rank
     */
    public function __construct($id, $name, $towerLevel, $clanId, $clanJoinDate, $clanJoinTowerLevel, $categoryId, $score, $rank)
    {
        $this->id = $id;
        $this->name = $name;
        $this->towerLevel = $towerLevel;
        $this->clanId = $clanId;
        $this->clanJoinDate = new DateTime($clanJoinDate);
        $this->clanJoinTowerLevel = $clanJoinTowerLevel;
        $this->categoryId = $categoryId;
        $this->score = $score;
        $this->rank = $rank;
    }


    public function print_r(){
        return '       ID: ' . $this->id . ' / Name: ' . $this->name . ' / Tower Level: ' .
            $this->towerLevel . ' / Member since: ' . $this->clanJoinDate->format('d.m.j') .
            ' / Score: ' . $this->score;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getTowerLevel()
    {
        return $this->towerLevel;
    }

    /**
     * @param mixed $towerLevel
     */
    public function setTowerLevel($towerLevel)
    {
        $this->towerLevel = $towerLevel;
    }

    /**
     * @return mixed
     */
    public function getClanId()
    {
        return $this->clanId;
    }

    /**
     * @param mixed $clanId
     */
    public function setClanId($clanId)
    {
        $this->clanId = $clanId;
    }

    /**
     * @return DateTime
     */
    public function getClanJoinDate()
    {
        return $this->clanJoinDate;
    }

    /**
     * @param DateTime $clanJoinDate
     */
    public function setClanJoinDate($clanJoinDate)
    {
        $this->clanJoinDate = $clanJoinDate;
    }

    /**
     * @return mixed
     */
    public function getClanJoinTowerLevel()
    {
        return $this->clanJoinTowerLevel;
    }

    /**
     * @param mixed $clanJoinTowerLevel
     */
    public function setClanJoinTowerLevel($clanJoinTowerLevel)
    {
        $this->clanJoinTowerLevel = $clanJoinTowerLevel;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param mixed $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param mixed $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }
}