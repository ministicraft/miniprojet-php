<?php
/**
 * Created by IntelliJ IDEA.
 * User: world
 * Date: 24/11/2016
 * Time: 15:42
 */

namespace App\DAO;

include_once __DIR__.'/../Model/Promo.php';
use App\Model\Promo;

class PromoDAO
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->setDb($db);
    }

    public function getList(){
        $dbh = $this->getDb();
        foreach($dbh->query('SELECT * FROM promo') as $row) {
            $promos[] = $this->buildPromo($row);
        }
        return $promos;
    }

    public function get($id){
        $dbh = $this->getDb();
        $stmt = $dbh->prepare("SELECT * FROM promo WHERE id = ?");
        if ($stmt->execute(array($id))) {
            while ($row = $stmt->fetch()) {
                $promo = $this->buildPromo($row);
            }
        }
        return $promo;
    }

    private function buildPromo(array $row){
        $promo = new Promo();
        $promo->setId($row['id']);
        $promo->setCycle($row['cycle']);
        $promo->setAnnee($row['annee']);
        $promo->setLocalisation($row['localisation']);
        return $promo;
    }

    public function getListLoc(){
        $dbh = $this->getDb();
        foreach($dbh->query('SELECT * FROM localisations') as $row) {
            $locs[] = $row['localisation'];
        }
        return $locs;
    }

    public function getListAnnee(){
        $dbh = $this->getDb();
        foreach($dbh->query('SELECT * FROM annee') as $row) {
            $annees[] = $row['annee'];
        }
        return $annees;
    }

    public function getListCycle(){
        $dbh = $this->getDb();
        foreach($dbh->query('SELECT * FROM cycles') as $row) {
            $cycles[] = $row['cycle'];
        }
        return $cycles;
    }

    public function addCycle($cycle){
        $dbh = $this->getDb();
        $stmt = $dbh->prepare("INSERT INTO  doc_rentree.cycles (cycle)VALUES (?)");
        $stmt->execute(array($cycle));
    }
    public function addLoc($loc){
        $dbh = $this->getDb();
        $stmt = $dbh->prepare("INSERT INTO  doc_rentree.localisations (localisation)VALUES (?)");
        $stmt->execute(array($loc));
    }
    public function addPromo($cycle,$loc,$annee){
        $dbh = $this->getDb();
        $stmt = $dbh->prepare("INSERT INTO  doc_rentree.promo (id ,cycle ,localisation ,annee)VALUES (NULL , ?, ?, ?)");
        $stmt->execute(array($cycle,$loc,$annee));
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param mixed $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

}