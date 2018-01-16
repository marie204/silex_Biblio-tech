<?php
/**
*@Entity
*@Table(name="utilisateur")
*/
class Utilisateur
{
    /**
     *@Column(type="integer")
     *@GeneratedValue
     *@user_id
     */

    /**
     * One User has many comments.
     * @OneToMany(targetEntity="commentaire", mappedBy="utilisateur")
     */
    private $user_id;

     /**
     *@Column(type="integer")
     *@id_statut
     */

    /**
     * Many Users have one statut.
     * @ManyToOne(targetEntity="statut", inversedBy="Utilisateur")
     */
    private $id_statut;

    /**
     *@Column(type="string")
     */
    private $user_pseudo;

    /**
     *@Column(type="string")
     */
    private $user_mdp;


    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getIdStatut()
    {
        return $this->id_statut;
    }

    public function setIdStatut($id_statut)
    {
        $this->id_statut = $id_statut;

        return $this;
    }

    public function getUserPseudo()
    {
        return $this->user_pseudo;
    }

    public function setUserPseudo($user_pseudo)
    {
        $this->user_pseudo = $user_pseudo;

        return $this;
    }

    public function getUserMdp()
    {
        return $this->user_mdp;
    }

    public function setUserMdp($user_mdp)
    {
        $this->user_mdp = $user_mdp;

        return $this;
    }


