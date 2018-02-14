<?php
/**
 * Commentaire entity
 */

namespace EntityManager; // Le fichier Commentaire est dans le dossier EntityManager

use Doctrine\Mapping as ORM;

/**
 * Commentaire entity
 *
 * commentaire des livres
 *
 * @Entity
 * @Table(name="commentaire")
 */
class Commentaire {

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
     * date commentaire
     *
     * @var date
     * @Column(name="date", type="date")
     */
    private $date;

    /**
     * description commentaire
     *
     * @var string
     * @Column(name="description", type="text")
     */
    private $description;

    /**
     * utilisateur linked to this commentaire
     *
     * @ManyToOne(targetEntity="EntityManager\Utilisateur", inversedBy="commentaire")
     */
    private $utilisateur;

    /**
     * livre linked to this commentaire
     *
     * @ManyToOne(targetEntity="EntityManager\Livre", inversedBy="commentaire")
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
     * Set Date
     *
     * @param date $date
     *
     * @return Commentaire
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Get Date
     *
     * @return date
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set Description
     *
     * @param string $description
     *
     * @return Commentaire
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
     * Set Utilisateur
     *
     * @param \EntityManager\Utilisateur $utilisateur
     */
    public function setUtilisateur($utilisateur) {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    /**
     * Get Utilisateur
     * @return \EntityManager\Utilisateur
     */
    public function getUtilisateur() {
        return $this->utilisateur;
    }

    /**
     * Set Livre
     *
     * @param \EntityManager\Livre $livre
     */
    public function setLivre($livre) {
        $this->livre = $livre;
        return $this;
    }

    /**
     * Get Livre
     * @return \EntityManager\Livre
     */
    public function getLivre() {
        return $this->livre;
    }  
}



