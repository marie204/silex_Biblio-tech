<?php
/**
 * Utilisateur entity
 */

namespace EntityManager; // Le fichier Utilisateur est dans le dossier EntityManager

use Doctrine\Mapping as ORM;

/**
 * Utilisateur entity
 *
 * liste des utilisateurs
 *
 * @Entity
 * @Table(name="utilisateur")
 */
class Utilisateur {

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
     * Pseudo de l'utilisateur
     *
     * @var string
     * @Column(name="pseudo", type="string", length=255)
     */
    private $pseudo;

    /**
     * Mot de passe de l'utilisateur
     *
     * @var string
     * @Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * commentaire linked to this utilisateur
     *
     * @OneToMany(targetEntity="EntityManager\Commentaire", mappedBy="utilisateur")
     */
    private $commentaire;

    /**
     * statut linked to this utilisateur
     *
     * @ManyToOne(targetEntity="EntityManager\Statut", inversedBy="utilisateur")
     */
    private $statut;

    /**
     * emprunt linked to this utilisateur
     *
     * @OneToMany(targetEntity="EntityManager\Emprunt", mappedBy="utilisateur")
     */
    private $emprunt;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set Pseudo
     *
     * @param string $pseudo
     *
     * @return Utilisateur
     */
    public function setPseudo($pseudo) {
        $this->pseudo = $pseudo;
        return $this;
    }

    /**
     * Get Pseudo
     *
     * @return string
     */
    public function getPseudo() {
        return $this->pseudo;
    }

    /**
     * Set Password
     *
     * @param string $password
     *
     * @return Utilisateur
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * Get Password
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set Statut
     *
     * @param \EntityManager\Statut $statut
     */
    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }

    /**
     * Get Statut
     * @return \EntityManager\Statut
     */
    public function getStatut() {
        return $this->statut;
    } 
}

