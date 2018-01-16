<?php
/**
*@Entity
*@Table(name="genre")
*/
class Genre
{
    /**
     *@Column(type="integer")
     *@GeneratedValue
     *@genre_id
     */

    /**
     * Many genres have many genres.
     * @ManyToMany(targetEntity="genrelivre", inversedBy="genre")
     */
    private $genre_id;

     /**
     *@Column(type="integer")
     *@intit_genre
     */
    private $intit_genre;



    public function getGenreId()
    {
        return $this->genre_id;
    }

    public function setGenreId($genre_id)
    {
        $this->genre_id = $genre_id;

        return $this;
    }

    public function getIntitGenre()
    {
        return $this->intit_genre;
    }

    public function setIntitGenre($intit_genre)
    {
        $this->intit_genre = $intit_genre;

        return $this;
    }


 