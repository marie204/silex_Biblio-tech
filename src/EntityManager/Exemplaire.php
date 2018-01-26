<?php
/**
 * Exemplaire entity
 */

namespace EntityManager; // Le fichier Exemplaire est dans le dossier EntityManager

use Doctrine\Mapping as ORM;

/**
 * Exemplaire entity
 *
 * exemplaire des livres
 *
 * @Entity
 * @Table(name="exemplaire")
 */
class Exemplaire {
    
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
     * Etat
     *
     * @var int
     * @Column(name="etat", type="integer")
     */
    private $etat;

    /**
     * livre linked to this exemplaire
     *
     * @ManyToOne(targetEntity="EntityManager\Livre", inversedBy="exemplaire")
     */
    private $livre;

    /**
     * emprunt linked to this exemplaire
     *
     * @OneToMany(targetEntity="EntityManager\Emprunt", mappedBy="exemplaire")
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
     * Set Etat
     *
     * @param string $etat
     *
     * @return Exemplaire
     */
    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }

    /**
     * Get Etat
     *
     * @return string
     */
    public function getEtat() {
        return $this->etat;
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

