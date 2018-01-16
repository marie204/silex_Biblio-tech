<?php
/**
*@Entity
*@Table(name="emprunt")
*/
class emprunt
{
    /**
     *@Column(type="integer")
     *@GeneratedValue
     *@id_commentaire
     */
    private $emprunt_id;

    /**
     *@Column(type="date")
     */
    private $debut_emprunt;

    /**
     *@Column(type="date")
     */
    private $fin_emprunt;

    /**
     *@Column(type="string")
     */
    private $statut_emprunt;

     /**
     *@Column(type="integer")
     *@exemp_id
     */

    /**
     * Many loans have many exemps.
     * @ManyToMany(targetEntity="exemp", inversedBy="emprunt")
     */
    private $exemp_id; 

     /**
     *@Column(type="integer")
     *@user_id
     */

    /**
     * Many loans have one user.
     * @ManyToOne(targetEntity="user", inversedBy="emprunt")
     */
    private $user_id; 


/**
     * @return mixed
     */
    public function getEmpruntId()
    {
        return $this->emprunt_id;
    }

    /**
     * @param mixed $emprunt_id
     *
     * @return self
     */
    public function setEmpruntId($emprunt_id)
    {
        $this->emprunt_id = $emprunt_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDebutEmprunt()
    {
        return $this->debut_emprunt;
    }

    /**
     * @param mixed $debut_emprunt
     *
     * @return self
     */
    public function setDebutEmprunt($debut_emprunt)
    {
        $this->debut_emprunt = $debut_emprunt;

        return $this;
    }

    public function getFinEmprunt()
    {
        return $this->fin_emprunt;
    }

    public function setFinEmprunt($fin_emprunt)
    {
        $this->fin_emprunt = $fin_emprunt;

        return $this;
    }

    public function getStatutEmprunt()
    {
        return $this->statut_emprunt;
    }

    public function setStatutEmprunt($statut_emprunt)
    {
        $this->statut_emprunt = $statut_emprunt;

        return $this;
    }

    public function getExempId()
    {
        return $this->exemp_id;
    }

    public function setExempId($exemp_id)
    {
        $this->exemp_id = $exemp_id;

        return $this;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }
