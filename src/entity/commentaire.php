<?php
/**
*@Entity
*@Table(name="commentaire")
*/
class commentaire
{
    /**
     *@Column(type="integer")
     *@GeneratedValue
     *@id_commentaire
     */
    private $id_commentaire;

    /**
     *@Column(type="date")
     */
    private $com_date;

    /**
     *@Column(type="string")
     */
    private $com_desc;

     /**
     *@Column(type="integer")
     *@user_id
     */

    /**
     * Many comments have one user.
     * @ManyToOne(targetEntity="livre", inversedBy="commentaire")
     */
    private $user_id; 

     /**
     *@Column(type="integer")
     *@li_id
     */

    /**
     * Many comments have many books.
     * @ManyToMany(targetEntity="livre", inversedBy="commentaire")
     */
    private $li_id; 


    public function getIdCommentaire()
    {
        return $this->id_commentaire;
    }

    public function getComDate()
    {
        return $this->com_date;
    }

    public function getComDesc()
    {
        return $this->com_desc;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getLiId()
    {
        return $this->li_id;
    

    public function setIdCommentaire($id_commentaire)
    {
        $this->id_commentaire = $id_commentaire;

        return $this;
    }

    public function setComDate($com_date)
    {
        $this->com_date = $com_date;

        return $this;
    }

    public function setComDesc($com_desc)
    {
        $this->com_desc = $com_desc;

        return $this;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function setLiId($li_id)
    {
        $this->li_id = $li_id;

        return $this;
    }
}



