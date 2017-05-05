<?php

namespace Rehyved\openid\client\jwk;


use Rehyved\helper\Base64Url;

/**
 * Represents a Json Web Key as defined in http://tools.ietf.org/html/rfc7517.
 */
class JsonWebKey
{

    private $certificateClauses = array();
    private $keyOps = array();

    private $alg;
    private $crv;
    private $d;
    private $dp;
    private $dq;
    private $e;
    private $k;
    private $kid;
    private $kty;
    private $n;
    private $oth;
    private $p;
    private $q;
    private $qi;
    private $use;
    private $x;
    private $x5t;
    private $x5tS256;
    private $x5u;
    private $y;

    /**
     * Initializes an new instance of JsonWebKey from a json object.
     * @param $key object that contains JSON Web Key parameters in JSON format.
     */
    public function __construct($key)
    {
        $this->alg = $key->alg ?? null;
        $this->crv = $key->crv ?? null;
        $this->d = $key->d ?? null;
        $this->dp = $key->dp ?? null;
        $this->dq = $key->dq ?? null;
        $this->e = $key->e ?? null;
        $this->k = $key->k ?? null;
        $this->keyOps = $key->keyOps ?? array();
        $this->kid = $key->kid ?? null;
        $this->kty = $key->kty ?? null;
        $this->n = $key->n ?? null;
        $this->oth = $key->oth ?? null;
        $this->p = $key->p ?? null;
        $this->q = $key->q ?? null;
        $this->qi = $key->qi ?? null;
        $this->use = $key->use ?? null;
        $this->certificateClauses = $key->x5c ?? array();
        $this->x5t = $key->x5t ?? null;
        $this->x5tS256 = $key->{'x5t#S25'} ?? null;
        $this->x5u = $key->x5u ?? null;
        $this->x = $key->x ?? null;
        $this->y = $key->y ?? null;
    }

    /**
     * Gets the 'alg' (KeyType)
     * @return mixed
     */
    public function getAlg()
    {
        return $this->alg;
    }

    /**
     * Sets the 'alg' (KeyType)
     * @param mixed $alg
     */
    public function setAlg($alg)
    {
        $this->alg = $alg;
    }

    /**
     * Gets the 'crv' (ECC - Curve)
     * @return mixed
     */
    public function getCrv()
    {
        return $this->crv;
    }

    /**
     * Sets the 'crv' (ECC - Curve)
     * @param mixed $crv
     */
    public function setCrv($crv)
    {
        $this->crv = $crv;
    }

    /**
     * Gets the 'd' (ECC - Private Key OR RSA - Private Exponent)..
     * @return mixed
     */
    public function getD()
    {
        return $this->d;
    }

    /**
     * Sets the 'd' (ECC - Private Key OR RSA - Private Exponent)..
     * @param mixed $d
     */
    public function setD($d)
    {
        $this->d = $d;
    }

    /**
     * Gets the 'dp' (RSA - First Factor CRT Exponent)..
     * @return mixed
     */
    public function getDp()
    {
        return $this->dp;
    }

    /**
     * Sets the 'dp' (RSA - First Factor CRT Exponent)..
     * @param mixed $dp
     */
    public function setDp($dp)
    {
        $this->dp = $dp;
    }

    /**
     * Gets the 'dq' (RSA - Second Factor CRT Exponent)..
     * @return mixed
     */
    public function getDq()
    {
        return $this->dq;
    }

    /**
     * Sets the 'dq' (RSA - Second Factor CRT Exponent)..
     * @param mixed $dq
     */
    public function setDq($dq)
    {
        $this->dq = $dq;
    }

    /**
     * Gets the 'e' (RSA - Exponent)..
     * @return mixed
     */
    public function getE()
    {
        return $this->e;
    }

    /**
     * Sets the 'e' (RSA - Exponent)..
     * @param mixed $e
     */
    public function setE($e)
    {
        $this->e = $e;
    }

    /**
     * Gets the 'k' (Symmetric - Key Value)..
     * @return mixed
     */
    public function getK()
    {
        return $this->k;
    }

    /**
     * Sets the 'k' (Symmetric - Key Value)..
     * @param mixed $k
     */
    public function setK($k)
    {
        $this->k = $k;
    }

    /**
     * Gets the 'key_ops' (Key Operations)..
     * @return array
     */
    public function getKeyOps()
    {
        return $this->keyOps;
    }

    /**
     * Sets the 'key_ops' (Key Operations)..
     * @param array $keyOps
     */
    public function setKeyOps(array $keyOps)
    {
        if ($keyOps == null) {
            throw new \InvalidArgumentException("KeyOps");
        }

        foreach ($keyOps as $keyOp) {
            $this->keyOps[] = $keyOp;
        }
    }

    /**
     * Gets the 'kid' (Key ID)..
     * @return mixed
     */
    public function getKid()
    {
        return $this->kid;
    }

    /**
     * Sets the 'kid' (Key ID)..
     * @param mixed $kid
     */
    public function setKid($kid)
    {
        $this->kid = $kid;
    }

    /**
     * Gets the 'kty' (Key Type)..
     * @return mixed
     */
    public function getKty()
    {
        return $this->kty;
    }

    /**
     * Sets the 'kty' (Key Type)..
     * @param mixed $kty
     */
    public function setKty($kty)
    {
        $this->kty = $kty;
    }

    /**
     * Gets the 'n' (RSA - Modulus)..
     * @return mixed
     */
    public function getN()
    {
        return $this->n;
    }

    /**
     * Sets the 'n' (RSA - Modulus)..
     * @param mixed $n
     */
    public function setN($n)
    {
        $this->n = $n;
    }

    /**
     * Gets the 'oth' (RSA - Other Primes Info)..
     * @return mixed
     */
    public function getOth()
    {
        return $this->oth;
    }

    /**
     * Sets the 'oth' (RSA - Other Primes Info)..
     * @param mixed $oth
     */
    public function setOth($oth)
    {
        $this->oth = $oth;
    }

    /**
     * Gets the 'p' (RSA - First Prime Factor)..
     * @return mixed
     */
    public function getP()
    {
        return $this->p;
    }

    /**
     * Sets the 'p' (RSA - First Prime Factor)..
     * @param mixed $p
     */
    public function setP($p)
    {
        $this->p = $p;
    }

    /**
     * Gets the 'q' (RSA - Second  Prime Factor)..
     * @return mixed
     */
    public function getQ()
    {
        return $this->q;
    }

    /**
     * Sets the 'q' (RSA - Second  Prime Factor)..
     * @param mixed $q
     */
    public function setQ($q)
    {
        $this->q = $q;
    }

    /**
     * Gets the 'qi' (RSA - First CRT Coefficient)..
     * @return mixed
     */
    public function getQi()
    {
        return $this->qi;
    }

    /**
     * Sets the 'qi' (RSA - First CRT Coefficient)..
     * @param mixed $qi
     */
    public function setQi($qi)
    {
        $this->qi = $qi;
    }

    /**
     * Gets the 'use' (Public Key Use)..
     * @return mixed
     */
    public function getUse()
    {
        return $this->use;
    }

    /**
     * Sets the 'use' (Public Key Use)..
     * @param mixed $use
     */
    public function setUse($use)
    {
        $this->use = $use;
    }

    /**
     * Gets the 'x' (ECC - X Coordinate)..
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Sets the 'x' (ECC - X Coordinate)..
     * @param mixed $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    public function getX5c(): array
    {
        return $this->certificateClauses;
    }

    public function setX5c(array $clauses)
    {
        foreach ($clauses as $clause) {
            $this->certificateClauses[] = $clause;
        }
    }

    /**
     * Gets the 'x5t' (X.509 Certificate SHA-1 thumbprint)..
     * @return mixed
     */
    public function getX5t()
    {
        return $this->x5t;
    }

    /**
     * Sets the 'x5t' (X.509 Certificate SHA-1 thumbprint)..
     * @param mixed $x5t
     */
    public function setX5t($x5t)
    {
        $this->x5t = $x5t;
    }

    /**
     * Gets the 'x5t#S256' (X.509 Certificate SHA-1 thumbprint)..
     * @return mixed
     */
    public function getX5tS256()
    {
        return $this->x5tS256;
    }

    /**
     * Sets the 'x5t#S256' (X.509 Certificate SHA-1 thumbprint)..
     * @param mixed $x5tS256
     */
    public function setX5tS256($x5tS256)
    {
        $this->x5tS256 = $x5tS256;
    }

    /**
     * Gets 'x5u' (X.509 URL)..
     * @return mixed
     */
    public function getX5u()
    {
        return $this->x5u;
    }

    /**
     * Sets the 'x5u' (X.509 URL)..
     * @param mixed $x5u
     */
    public function setX5u($x5u)
    {
        $this->x5u = $x5u;
    }

    /**
     * Gets the 'y' (ECC - Y Coordinate)..
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Sets the 'y' (ECC - Y Coordinate)..
     * @param mixed $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }

    public function getKeySize(): int
    {
        if ($this->kty === JsonWebAlgorithmsKeyTypes::RSA) {
            return strlen(Base64Url::decode($this->n)) * 8;
        } else if ($this->kty === JsonWebAlgorithmsKeyTypes::ELLIPTIC_CURVE) {
            return strlen(Base64Url::decode($this->x)) * 8;
        } else if ($this->kty === JsonWebAlgorithmsKeyTypes::OCTET) {
            return strlen(Base64Url::decode($this->k)) * 8;
        } else {
            return 0;
        }
    }

    public function hasPrivateKey(): bool
    {
        if ($this->kty === JsonWebAlgorithmsKeyTypes::RSA) {
            return $this->d != null && $this->dp != null && $this->dq != null && $this->p != null && $this->q != null && $this->qi != null;
        } else if ($this->kty === JsonWebAlgorithmsKeyTypes::ELLIPTIC_CURVE) {
            return $this->d != null;
        } else {
            return false;
        }
    }
}