<?php
/**
*@Entity
*@Table(name="genrelivre")
*/
class Genrelivre
{
    /**
     *@Column(type="integer")
     *@GeneratedValue
     *@genre_id
     */

    /**
     * Many genres have many genres.
     * @ManyToMany(targetEntity="genre", inversedBy="genrelivre")
     */
    private $genre_id;

     /**
     *@Column(type="integer")
     *@li_id
     */
    private $li_id;



    public function getGenreId()
    {
        return $this->genre_id;
    }

    public function setGenreId($genre_id)
    {
        $this->genre_id = $genre_id;

        return $this;
    }

    public function getLiId()
    {
        return $this->li_id;
    }

    public function setLiId($li_id)
    {
        $this->li_id = $li_id;

        return $this;
    }



