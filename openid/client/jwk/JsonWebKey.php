<?php

namespace com\rehyved\openid\client\jwk;


use com\rehyved\helper\Base64Url;

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

    public function getKeyOps()
    {
        return $this->keyOps;
    }

    public function setKeyOps(array $keyOps)
    {
        if ($keyOps == null) {
            throw new \InvalidArgumentException("KeyOps");
        }

        foreach ($keyOps as $keyOp) {
            $this->keyOps[] = $keyOp;
        }
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

    /**
     * @return mixed
     */
    public function getAlg()
    {
        return $this->alg;
    }

    /**
     * @param mixed $alg
     */
    public function setAlg($alg)
    {
        $this->alg = $alg;
    }

    /**
     * @return mixed
     */
    public function getCrv()
    {
        return $this->crv;
    }

    /**
     * @param mixed $crv
     */
    public function setCrv($crv)
    {
        $this->crv = $crv;
    }

    /**
     * @return mixed
     */
    public function getD()
    {
        return $this->d;
    }

    /**
     * @param mixed $d
     */
    public function setD($d)
    {
        $this->d = $d;
    }

    /**
     * @return mixed
     */
    public function getDp()
    {
        return $this->dp;
    }

    /**
     * @param mixed $dp
     */
    public function setDp($dp)
    {
        $this->dp = $dp;
    }

    /**
     * @return mixed
     */
    public function getDq()
    {
        return $this->dq;
    }

    /**
     * @param mixed $dq
     */
    public function setDq($dq)
    {
        $this->dq = $dq;
    }

    /**
     * @return mixed
     */
    public function getE()
    {
        return $this->e;
    }

    /**
     * @param mixed $e
     */
    public function setE($e)
    {
        $this->e = $e;
    }

    /**
     * @return mixed
     */
    public function getK()
    {
        return $this->k;
    }

    /**
     * @param mixed $k
     */
    public function setK($k)
    {
        $this->k = $k;
    }

    /**
     * @return mixed
     */
    public function getKid()
    {
        return $this->kid;
    }

    /**
     * @param mixed $kid
     */
    public function setKid($kid)
    {
        $this->kid = $kid;
    }

    /**
     * @return mixed
     */
    public function getKty()
    {
        return $this->kty;
    }

    /**
     * @param mixed $kty
     */
    public function setKty($kty)
    {
        $this->kty = $kty;
    }

    /**
     * @return mixed
     */
    public function getN()
    {
        return $this->n;
    }

    /**
     * @param mixed $n
     */
    public function setN($n)
    {
        $this->n = $n;
    }

    /**
     * @return mixed
     */
    public function getOth()
    {
        return $this->oth;
    }

    /**
     * @param mixed $oth
     */
    public function setOth($oth)
    {
        $this->oth = $oth;
    }

    /**
     * @return mixed
     */
    public function getP()
    {
        return $this->p;
    }

    /**
     * @param mixed $p
     */
    public function setP($p)
    {
        $this->p = $p;
    }

    /**
     * @return mixed
     */
    public function getQ()
    {
        return $this->q;
    }

    /**
     * @param mixed $q
     */
    public function setQ($q)
    {
        $this->q = $q;
    }

    /**
     * @return mixed
     */
    public function getQi()
    {
        return $this->qi;
    }

    /**
     * @param mixed $qi
     */
    public function setQi($qi)
    {
        $this->qi = $qi;
    }

    /**
     * @return mixed
     */
    public function getUse()
    {
        return $this->use;
    }

    /**
     * @param mixed $use
     */
    public function setUse($use)
    {
        $this->use = $use;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param mixed $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * @return mixed
     */
    public function getX5t()
    {
        return $this->x5t;
    }

    /**
     * @param mixed $x5t
     */
    public function setX5t($x5t)
    {
        $this->x5t = $x5t;
    }

    /**
     * @return mixed
     */
    public function getX5tS256()
    {
        return $this->x5tS256;
    }

    /**
     * @param mixed $x5tS256
     */
    public function setX5tS256($x5tS256)
    {
        $this->x5tS256 = $x5tS256;
    }

    /**
     * @return mixed
     */
    public function getX5u()
    {
        return $this->x5u;
    }

    /**
     * @param mixed $x5u
     */
    public function setX5u($x5u)
    {
        $this->x5u = $x5u;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param mixed $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }
}