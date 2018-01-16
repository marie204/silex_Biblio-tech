<?php
/**
*@Entity
*@Table(name="exemplaire")
*/
class Exemplaire
{
    /**
     *@Column(type="integer")
     *@GeneratedValue
     *@li_id
     */

    /**
     * Many exemps have many loans.
     * @ManyToOne(targetEntity="emprunt", inversedBy="exemplaire")
     */
    private $exemp_id;

     /**
     *@Column(type="integer")
     *@li_id
     */

    /**
     * Many exemps have one book.
     * @ManyToOne(targetEntity="livre", inversedBy="exemplaire")
     */
    private $li_id;


    public function getExempId()
    {
        return $this->exemp_id;
    }

    public function setExempId($exemp_id)
    {
        $this->exemp_id = $exemp_id;

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

