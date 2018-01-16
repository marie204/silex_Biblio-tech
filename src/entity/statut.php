<?php
/**
*@Entity
*@Table(name="statut")
*/
class Statut
{
    /**
     *@Column(type="integer")
     *@GeneratedValue
     *@id_statut
     */

    /**
     * one statut has many users.
     * @OneToMany(targetEntity="user", mappedBy="statut")
     */
    private $id_statut;

     /**
     *@Column(type="integer")
     *@intitut_stat
     */
    private $intitut_stat;


    public function getIdStatut()
    {
        return $this->id_statut;
    }

    public function setIdStatut($id_statut)
    {
        $this->id_statut = $id_statut;

        return $this;
    }

    public function getIntitutStat()
    {
        return $this->intitut_stat;
    }

    public function setIntitutStat($intitut_stat)
    {
        $this->intitut_stat = $intitut_stat;

        return $this;
    }



