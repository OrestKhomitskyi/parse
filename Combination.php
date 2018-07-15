<?php



class Combination{
    public $sku;
    public $bore;
    public $stroke;
    public $rod;
    public $retracted;
    public $extended;
    public $pin;
    public $port_size;
    public $column_load;
    public $price;
    public $width;
    public $height;
    public $depth;
    public $weight;
    public $oil_volume;
    //public $replacement;


    /**
     * Combination constructor.
     * @param $sku
     * @param $bore
     * @param $stroke
     * @param $rod
     * @param $retracted
     * @param $extended
     * @param $pin
     * @param $port_size
     * @param $column_load
     * @param $price
     * @param $width
     * @param $height
     * @param $depth
     */
    public function __construct($sku, $bore, $stroke, $rod, $retracted, $extended, $pin, $port_size, $column_load, $price, $width, $height, $depth,$weight,$oil_volume)
    {
        $this->sku = $sku;
        $this->bore = $bore;
        $this->stroke = $stroke;
        $this->rod = $rod;
        $this->retracted = $retracted;
        $this->extended = $extended;
        $this->pin = $pin;
        $this->port_size = $port_size;
        $this->column_load = $column_load;
        $this->price = $price;
        $this->width = $width;
        $this->height = $height;
        $this->depth = $depth;
        $this->weight=$weight;
        $this->oil_volume=$oil_volume;
        //$this->replacement=$replacement;
    }


}
