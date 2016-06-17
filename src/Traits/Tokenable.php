<?php
namespace Vuer\Token\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Vuer\Token\Models\Token;

trait Tokenable
{
    /**
     * Generate a string for Token.
     * @param   integer  token length
     * @return  string
     */
    protected function generateTokenString($length)
    {
        return Str::random($length);
    }

    /**
     * Relation to the Token.
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function token()
    {
        return $this->morphOne(Token::class, 'tokenable');
    }

    /**
     * Get the Token by the type.
     * @param   string  $type
     * @return  Token
     */
    public function getToken($type)
    {
        return $this->token()->where('type', $type)->first();
    }

    /**
     * Check the token.
     * @param   string  $token
     * @return  boolean
     */
    public function checkToken($token)
    {
        return (bool) $this->token()->where('token', $token)->where('expiration_date', '>', Carbon::now())->count();
    }

    /**
     * Delete the token.
     * @param   string  token type
     * @return  boolean
     */
    public function deleteToken($type)
    {
        return $this->token()->where('type', $type)->delete();
    }

    /**
     * Create new token and return the instance.
     * @param  string  $type   token type
     * @param  integer $expire expire in minutes
     * @param  integer $length key length
     * @return Token
     */
    public function createToken($type, $expire = 60, $length = 48)
    {
        return $this->token()->create([
            'token'           => $this->generateTokenString($length),
            'expiration_date' => Carbon::now()->addMinutes($expire),
            'type'            => $type,
        ]);
    }

}
