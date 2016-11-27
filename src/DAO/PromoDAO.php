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

    public function get(Promo $promo){
        $tmp = $this->getList()[$promo];
        return $tmp;
    }

    private function buildPromo(array $row){
        $promo = new Promo();
        $promo->setId($row['id']);
        $promo->setCycle($row['cycle']);
        $promo->setAnnee($row['annee']);
        $promo->setLocalisation($row['localisation']);
        return $promo;
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