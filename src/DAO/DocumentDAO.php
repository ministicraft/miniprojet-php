<?php
/**
 * Created by IntelliJ IDEA.
 * User: world
 * Date: 24/11/2016
 * Time: 15:43
 */

namespace App\DAO;

include_once __DIR__.'/../Model/Document.php';
use App\Model\Document;

class DocumentDAO
{
    private $db;

    public function __construct(\PDO $db){
        $this->setDb($db);
    }

    public function getList(){
        $dbh = $this->getDb();
        foreach($dbh->query('SELECT * FROM document') as $row) {
            $documents[] = $this->buildDocument($row);
        }
        return $documents;
    }

    public function get($id){
        $dbh = new \PDO('mysql:host=localhost;dbname=doc_rentree', 'rentree', 'rentree');
        $row = $dbh->query('SELECT * FROM document');
        $document = $this->buildDocument($row);
        return $document;
    }

    public function addDocument($rang,$promo,$libelle,$fichier){
        $dbh = $this->getDb();
        $stmt = $dbh->prepare('INSERT INTO  doc_rentree.document (id ,rang ,promo ,libelle ,fichier)VALUES (NULL , ?, ?, ?, ?)');
        $stmt->execute(array($rang,$promo,$libelle,$fichier));
    }

    /**
     * @param array $row
     * @return Document
     */
    private function buildDocument(array $row){
        $document = new Document();
        $document->setId($row['id']);
        $document->setPromo($row['promo']);
        $document->setRang($row['rang']);
        $document->setLibelle($row['libelle']);
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