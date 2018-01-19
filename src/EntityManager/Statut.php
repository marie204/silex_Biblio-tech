<?php
/**
 * Statut entity
 */

namespace EntityManager; // Le fichier Statut est dans le dossier EntityManager

use Doctrine\Mapping as ORM;

/**
 * Statut entity
 *
 * statut utilisateur
 *
 * @Entity
 * @Table(name="statut")
 */
class Statut {

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
     * Intitule du statut
     *
     * @var string
     * @Column(name="intitule", type="string", length=255)
     */
    private $intitule;

    /**
     * utilisateur linked to this statut
     *
     * @OneToMany(targetEntity="EntityManager\Utilisateur", mappedBy="statut")
     */
    private $utilisateur;

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
     * @return Statut
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
}


