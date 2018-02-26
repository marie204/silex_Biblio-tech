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
     * Email de l'utilisateur
     *
     * @var string
     * @Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * question de l'utilisateur
     *
     * @var string
     * @Column(name="question", type="string", length=255)
     */
    private $question;

    /**
     * reponse de l'utilisateur
     *
     * @var string
     * @Column(name="reponse", type="string", length=255)
     */
    private $reponse;

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
     * Set Email
     *
     * @param string $email
     *
     * @return Utilisateur
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * Get Email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

       /**
     * Set Question
     *
     * @param string $question
     *
     * @return Utilisateur
     */
    public function setQuestion($question) {
        $this->question = $question;
        return $this;
    }

    /**
     * Get Question
     *
     * @return string
     */
    public function getQuestion() {
        return $this->question;
    }

       /**
     * Set Reponse
     *
     * @param string $reponse
     *
     * @return Utilisateur
     */
    public function setReponse($reponse) {
        $this->reponse = $reponse;
        return $this;
    }

    /**
     * Get Reponse
     *
     * @return string
     */
    public function getReponse() {
        return $this->reponse;
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

