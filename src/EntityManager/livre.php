<?php
/**
 * Livre entity
 */

namespace EntityManager; // Le fichier Livre est dans le dossier EntityManager

use Doctrine\Mapping as ORM;

/**
 * Livre entity
 *
 * liste des livres
 *
 * @Entity
 * @Table(name="livre")
 */
class Livre {

    /**
     * id
     *
     * @var int
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * date d'ajout du livre
     *
     * @var date
     * @Column(name="dateAjout", type="date")
     */
    private $dateAjout;

    /**
     * Titre du livre
     *
     * @var string
     * @Column(name="titre", type="string", length=255)
     */
    private $title;

    /**
     * Auteur du livre
     *
     * @var string
     * @Column(name="auteur", type="string", length=255)
     */
    private $auteur;

    /**
     * Description du livre
     *
     * @var text
     * @Column(name="description", type="text")
     */
    private $description;

    /**
     * ISBN du livre
     *
     * @var string
     * @Column(name="isbn", type="string", length=20)
     */
    private $isbn;

    /**
     * Langue du livre
     *
     * @var string
     * @Column(name="langue", type="string", length=255)
     */
    private $langue;

    /**
     * Nombre de pages du livre
     *
     * @var int
     * @Column(name="pages", type="integer")
     */
    private $pages;

    /**
     * Image du livre
     *
     * @var string
     * @Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * commentaire linked to this livre
     *
     * @OneToMany(targetEntity="EntityManager\Commentaire", mappedBy="livre")
     */
    private $commentaire;

    /**
     * Many Livre have Many Genre
     * @ManyToMany(targetEntity="EntityManager\Genre", inversedBy="livre")
     * @JoinTable(name="livre_genre")
     */
    private $genre;

    /**
     * Nombre de etats du livre
     *
     * @var int
     * @Column(name="etatf", type="integer")
     */
    private $etat;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set dateAjout
     *
     * @param date $dateAjout
     *
     * @return Livre
     */
    public function setDateAjout($dateAjout) {
        $this->dateAjout = $dateAjout;
        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return date
     */
    public function getDateAjout() {
        return $this->dateAjout;
    }

    /**
     * Set Title
     *
     * @param string $title
     *
     * @return Livre
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set Auteur
     *
     * @param string $auteur
     *
     * @return Livre
     */
    public function setAuteur($auteur) {
        $this->auteur = $auteur;
        return $this;
    }

    /**
     * Get Auteur
     *
     * @return string
     */
    public function getAuteur() {
        return $this->auteur;
    }

    /**
     * Set Description
     *
     * @param string $description
     *
     * @return Livre
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set ISBN
     *
     * @param string $isbn
     *
     * @return Livre
     */
    public function setIsbn($isbn) {
        $this->isbn = $isbn;
        return $this;
    }

    /**
     * Get ISBN
     *
     * @return string
     */
    public function getIsbn() {
        return $this->isbn;
    }

    /**
     * Set Image
     *
     * @param string $image
     *
     * @return Livre
     */
    public function setImage($image) {
        $this->image = $image;
        return $this;
    }

    /**
     * Get Image
     *
     * @return string
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set Langue
     *
     * @param string $langue
     *
     * @return Livre
     */
    public function setLangue($langue) {
        $this->langue = $langue;
        return $this;
    }

    /**
     * Get Langue
     *
     * @return string
     */
    public function getLangue() {
        return $this->langue;
    }

    /**
     * Set Pages
     *
     * @param int $pages
     *
     * @return Livre
     */
    public function setPages($pages) {
        $this->pages = $pages;
        return $this;
    }

    /**
     * Get Pages
     *
     * @return int
     */
    public function getPages() {
        return $this->pages;
    }

    /**
     * Set Etat
     *
     * @param int $etat
     *
     * @return Livre
     */
    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }

    /**
     * Get Etat
     *
     * @return int
     */
    public function getEtat() {
        return $this->etat;
    }

    /**
     * Get ArrayCollection
     *
     * @return ArrayCollection $genre
     */
    public function getGenre() {
        return $this->genre;
    }
 
    public function __construct() {
        $this->genre = new \Doctrine\Common\Collections\ArrayCollection();
    }
}


   