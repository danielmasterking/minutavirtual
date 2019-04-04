<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property string $usuario
 * @property string $password
 * @property string $nombres
 * @property string $apellidos
 * @property string $estado
 * @property string $login
 * @property string $created
 * @property string $updated
 *
 * @property RolUsuario[] $rolUsuarios
 */
class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    
	/*Propiedades necesaria para interfaz identity*/ 
    public $id;
    public $authKey;
    public $accessToken;
	
	/**
     * @inheritdoc
     */
    
	public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario', 'password', 'nombres', 'apellidos'], 'required'],
            [['login', 'created', 'updated'], 'safe'],
            [['usuario'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 60],
			[['area'], 'string', 'max' => 45],
            [['nombres', 'apellidos'], 'string', 'max' => 80],
            [['estado','ambas_areas','administrativo'], 'string', 'max' => 1],
			[['email'], 'string', 'max' => 150],
			[['cargo'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usuario' => 'Usuario',
            'password' => 'Password',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'estado' => 'Estado',
			'area' => 'Area',
            'login' => 'Login',
            'created' => 'Created',
            'updated' => 'Updated',
			'email' => 'Email',
			'cargo' => 'Cargo',
			'ambas_areas' => 'Seguridad y Riesgos',
			'administrativo' => 'Seguridad, Riesgos y Administración.',
        ];
    }
	
     /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['usuario' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
      
        return null;
    }	
	
    public static function findByUsername($username)
    {
       
        return null;
    }
    
    public function validatePassword($password)
    {
        //return $this->password === substr(hash('sha512', $password), 0,60);
         return $this->password === $password;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
    
    /*Obtener Usuario*/
     public function getId()
    {
        return $this->usuario;
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(RolUsuario::className(), ['usuario' => 'usuario']);
    }
	
	 public function getZonas()
    {
        return $this->hasMany(UsuarioZona::className(), ['usuario' => 'usuario']);
    }
	
     public function getMarcas()
    {
        return $this->hasMany(UsuarioMarca::className(), ['usuario' => 'usuario']);
    }
	
     public function getEmpresas()
    {
        return $this->hasMany(UsuarioEmpresa::className(), ['usuario' => 'usuario']);
    }	
	
	 public function getDistritos()
    {
        return $this->hasMany(UsuarioDistrito::className(), ['usuario' => 'usuario']);
    }
	
}
