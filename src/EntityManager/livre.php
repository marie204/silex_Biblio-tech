<?php
namespace EntityManager;//Le fichier livre est dans le dossier EntityManager
// src/EntityManager/livre.php

/*use Doctrine\ORM\Annotation as ORM;*/

/**
*@Entity
*@Table(name="livre")
*/
class Livre
{
    /**
     *@Column(type="integer")
     *@GeneratedValue
     *@Id
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
    private $langue;

    /**
     *@Column(type="string")
     */
    private $li_img;

    /**
     * @return mixed
     */
    public function getLiId()
    {
        return $this->li_id;
    }

    /**
     * @param mixed $li_id
     *
     * @return self
     */
    public function setLiId($li_id)
    {
        $this->li_id = $li_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLiDateAjout()
    {
        return $this->li_date_ajout;
    }

    /**
     * @param mixed $li_date_ajout
     *
     * @return self
     */
    public function setLiDateAjout($li_date_ajout)
    {
        $this->li_date_ajout = $li_date_ajout;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLiTitle()
    {
        return $this->li_title;
    }

    /**
     * @param mixed $li_title
     *
     * @return self
     */
    public function setLiTitle($li_title)
    {
        $this->li_title = $li_title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLiAuteur()
    {
        return $this->li_auteur;
    }

    /**
     * @param mixed $li_auteur
     *
     * @return self
     */
    public function setLiAuteur($li_auteur)
    {
        $this->li_auteur = $li_auteur;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLiDesc()
    {
        return $this->li_desc;
    }

    /**
     * @param mixed $li_desc
     *
     * @return self
     */
    public function setLiDesc($li_desc)
    {
        $this->li_desc = $li_desc;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLiIsbn()
    {
        return $this->li_isbn;
    }

    /**
     * @param mixed $li_isbn
     *
     * @return self
     */
    public function setLiIsbn($li_isbn)
    {
        $this->li_isbn = $li_isbn;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLiImg()
    {
        return $this->li_img;
    }

    /**
     * @param mixed $li_img
     *
     * @return self
     */
    public function setLiImg($li_img)
    {
        $this->li_img = $li_img;

        return $this;
    }

 /**
     * @return mixed
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * @param mixed $li_img
     *
     * @return self
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;

        return $this;
    }
 /**
     * @return mixed
     */
    public function getLiPages()
    {
        return $this->li_pages;
    }

    /**
     * @param mixed $li_pages
     *
     * @return self
     */
    public function setLiPages($li_pages)
    {
        $this->li_pages = $li_pages;

        return $this;
    }

}


   