<?php
/**
 * Created by IntelliJ IDEA.
 * User: world
 * Date: 24/11/2016
 * Time: 15:43
 */

namespace App\DAO;


use App\Model\Document;

class DocumentDAO
{
    private $db;

    private function __construct(\PDO $db){
        $this->setDb($db);
    }

    private function getList(){
        foreach ($this->getDb()->query('SELECT * FROM document') as $row){
            $documents[] = $this->buildPromo($row);
            return $documents;
        }
    }

    private function get($id){
        $row = $this->getDb()->query('SELECT * FROM document');
        $document = $this->buildPromo($row);
        return $document;
    }

    /**
     * @param array $row
     * @return Document
     */
    private function buildDocument(array $row){
        $document = new Document();
        $document->setId($row['id']);
        $document->setLibelle($row['libelle']);
        $document->setPromo($row['promo']);
        $document->setRang($row['rang']);
        $document->setFichier($row['fichier']);
        return $document;
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