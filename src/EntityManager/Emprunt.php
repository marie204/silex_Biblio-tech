<?php
/**
 * Emprunt entity
 */

namespace EntityManager; // Le fichier Emprunt est dans le dossier EntityManager

use Doctrine\Mapping as ORM;

/**
 * Emprunt entity
 *
 * emprunt des livres
 *
 * @Entity
 * @Table(name="emprunt")
 */
class Emprunt {

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
     * date debut emprunt
     *
     * @var date
     * @Column(name="dateDebut", type="date")
     */
    private $dateDebut;

    /**
     * date fin emprunt
     *
     * @var date
     * @Column(name="dateFin", type="date")
     */
    private $dateFin;

    /**
     * Statut emprunt
     *
     * @var string
     * @Column(name="statut", type="string", length=255)
     */
    private $statut;

    /**
     * utilisateur linked to this emprunt
     *
     * @ManyToOne(targetEntity="EntityManager\Utilisateur", inversedBy="emprunt")
     */
    private $utilisateur;

    /**
     * exemplaire linked to this emprunt
     *
     * @OneToMany(targetEntity="EntityManager\Exemplaire", mappedBy="emprunt")
     */
    private $exemplaire; 

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set dateDebut
     *
     * @param date $dateDebut
     *
     * @return Emprunt
     */
    public function setDateDebut($dateDebut) {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return date
     */
    public function getDateDebut() {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param date $dateFin
     *
     * @return Emprunt
     */
    public function setDateFin($dateFin) {
        $this->dateFin = $dateFin;
        return $this;
    }

    /**
     * Get dateFin
     *
     * @return date
     */
    public function getDateFin() {
        return $this->dateFin;
    }

    /**
     * Set Statut
     *
     * @param string $statut
     *
     * @return Emprunt
     */
    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }

    /**
     * Get Statut
     *
     * @return string
     */
    public function getStatut() {
        return $this->statut;
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
}
