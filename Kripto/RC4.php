<?php
class rc4{
 
    const ENCRYPT_MODE_NORMAL = 0x01;
    const ENCRYPT_MODE_UPDATE = 0x02;
    protected $password;
    protected $encryptMode;
    protected $sBox = array();
    protected $si = 0;
    protected $sj = 0;
    public function __construct($password, $encryptMode = 0x01)
    {
        $this->password = $password;
        $validMode = array(
            static::ENCRYPT_MODE_NORMAL, 
            static::ENCRYPT_MODE_UPDATE
        );
        if ( ! in_array($encryptMode, $validMode)) {
            throw new InvalidArgumentException("Invalid encrypt mode.");
        }
        $this->encryptMode = $encryptMode;
        $this->initCipher();
    }
    protected function  initCipher()
    //Subproses KSA 
    {
        $passwordLength = strlen($this->password);
        $pswd = array();
        //Inisialisasi i
        for ($i = 0; $i < 256; $i++) {
            $pswd[$i] = ord($this->password[$i % $passwordLength]);
            $this->sBox[$i] = $i;
        }
        //Permutasi i dan j
        for ($j = $i = 0; $i < 256; $i ++) {
            $j = ($j + $this->sBox[$i] + $pswd[$i]) % 256;
            list($this->sBox[$i], $this->sBox[$j]) = array($this->sBox[$j], $this->sBox[$i]);
        }
        $this->si = $this->sj = 0;
    }
    public function encrypt($txt)
    //Subproses PRGA 
    {
        $txtLength = strlen($txt);
        $ciphertext = "";
        for ($n = 0; $n < $txtLength; $n++) {
            $this->si = ($this->si + 1) % 256;
            $this->sj = ($this->sj + $this->sBox[$this->si]) % 256;
            list($this->sBox[$this->si], $this->sBox[$this->sj]) = array(
                $this->sBox[$this->sj], 
                $this->sBox[$this->si]
            );
            $k = $this->sBox[($this->sBox[$this->si] + $this->sBox[$this->sj]) % 256];
            $ciphertext .= chr(ord($txt[$n]) ^ $k);
        }
        if ($this->encryptMode & static::ENCRYPT_MODE_NORMAL) {
            $this->resetCipher();
        }
        return $ciphertext;
    }
    protected function resetCipher()
    {
        $this->initCipher();
    }
    public function decrypt($txt)
    {
        return $this->encrypt($txt);
    }
}
?>