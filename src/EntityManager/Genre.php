<?php
/**
 * Genre entity
 */

namespace EntityManager; // Le fichier Genre est dans le dossier EntityManager

use Doctrine\Mapping as ORM;

/**
 * Genre entity
 *
 * genre des livres
 *
 * @Entity
 * @Table(name="genre")
 */
class Genre {

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
     * intitule du genre
     *
     * @var string
     * @Column(name="intitule", type="string", length=255)
     */
    private $intitule;

    /**
     * Many Genre have Many Livre
     * @ManyToMany(targetEntity="EntityManager\Livre", mappedBy="genre")
     */
    private $livre;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set Intitule
     *
     * @param string $intitule
     *
     * @return Genre
     */
    public function setIntitule($intitule) {
        $this->intitule = $intitule;
        return $this;
    }

    /**
     * Get Intitule
     *
     * @return string
     */
    public function getIntitule() {
        return $this->intitule;
    }

    /**
     * Get ArrayCollection
     *
     * @return ArrayCollection $livre
     */
    public function getLivre() {
        return $this->livre;
    }
 
    public function __construct() {
        $this->livre = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
 