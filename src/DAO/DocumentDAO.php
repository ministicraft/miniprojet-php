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

    public function get($id)
    {
        $dbh = new \PDO('mysql:host=localhost;dbname=doc_rentree', 'rentree', 'rentree');
        $row = $dbh->query('SELECT * FROM document');
        $document = $this->buildDocument($row);
        return $document;
    }

    public function addDocument($rang, $promo, $libelle, $fichier)
    {
        $dbh = $this->getDb();
        $stmt = $dbh->prepare('INSERT INTO  doc_rentree.document (id ,rang ,promo ,libelle ,fichier)VALUES (NULL , ?, ?, ?, ?)');
        $stmt->execute(array($rang, $promo, $libelle, $fichier));
    }

    public function delDocument($id)
    {
        $dbh = $this->getDb();
        $stmt = $dbh->prepare("DELETE FROM doc_rentree.document WHERE document.id = ?");
        $stmt->execute(array($id));
    }

    public function editDocument($id, $rang, $promo, $libelle)
    {
        $dbh = $this->getDb();
        if ($libelle != null) {
            $stmt = $dbh->prepare('UPDATE doc_rentree.document SET libelle =  ? WHERE document.id = ?;');
            $stmt->execute(array($libelle, $id));
        }
        if ($rang != null || $rang != 0) {
            $stmt = $dbh->prepare('UPDATE doc_rentree.document SET rang =  ? WHERE document.id = ?;');
            $stmt->execute(array($rang, $id));
        }
        if ($promo != null) {
            $stmt = $dbh->prepare('UPDATE doc_rentree.document SET promo =  ? WHERE document.id = ?;');
            $stmt->execute(array($promo, $id));
        }
    }

}