<?php
/**
*@Entity
*@Table(name="livre")
*/
class Livre
{
    /**
     *@Column(type="integer")
     *@GeneratedValue
     *@li_id
     */

    /**
     * Many books have many exemps.
     * @ManyToMany(targetEntity="exemplaire", inversedBy="livre")
     */

    /**
     * Many books have many genres.
     * @ManyToMany(targetEntity="gengenrelivre", inversedBy="livre")
     */

    /**
     * One book has many comments.
     * @OneToMany(targetEntity="commentaire", mappedBy="livre")
     */
    private $li_id;

    /**
     *@Column(type="date")
     */
    private $li_date_ajout;

    /**
     *@Column(type="string")
     */
    private $li_title;

    /**
     *@Column(type="string")
     */
    private $li_auteur;

    /**
     *@Column(type="string")
     */
    private $li_desc;

    /**
     *@Column(type="string")
     */
    private $li_isbn;

    /**
     *@Column(type="string")
     */
    private $li_img;


    public function getId()
    {
        return $this->li_id;
    }

    public function getDate()
    {
        return $this->li_date_ajout;
    }

    public function getTitle()
    {
        return $this->li_title;
    }

    public function getAuteur()
    {
        return $this->li_auteur;
    }

    public function getDesc()
    {
        return $this->li_desc;
    }

    public function getIsbn()
    {
        return $this->li_isbn;
    }

    public function getImg()
    {
        return $this->li_img;
    }


    public function setTitle($li_title)
    {
        $this->title = $li_title;
    }

    public function setAuteur($li_auteur)
    {
        $this->auteur = $li_auteur;
    }

    public function setDesc($li_desc)
    {
        $this->desc = $li_desc;
    }

    public function setIsbn($li_isbn)
    {
        $this->isbn = $li_isbn;
    }

    public function setImg($li_img)
    {
        $this->img = $li_img;
    }

}