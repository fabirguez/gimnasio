<?php

class UserModel extends Model implements IModel
{
    private $id;
    private $nif;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $telefono;
    private $direccion;
    private $estado;
    private $imagen;
    private $rol_id;

    public function __construct()
    {
        parent::__construct();

        $this->nif = '';
        $this->nombre = '';
        $this->apellidos = '';
        $this->email = '';
        $this->password = '';
        $this->telefono = 0;
        $this->direccion = '';
        $this->estado = 0;
        $this->imagen = '';
        $this->rol_id = 0;
    }

    //fin constructor

    public function save()
    {
        try {
            $query = $this->prepare('INSERT INTO usuarios(nif,nombre,apellidos,email,password,telefono,direccion,estado,imagen,rol_id) 
                                    VALUES(:nif, :nombre, :apellidos, :email, :password, :telefono, :direccion, :estado, :imagen, :rol_id)');
            $query->execute([
                'nif' => $this->nif,
                'nombre' => $this->nombre,
                'apellidos' => $this->apellidos,
                'email' => $this->email,
                'password' => $this->password,
                'telefono' => $this->telefono,
                'direccion' => $this->direccion,
                'estado' => $this->estado,
                'imagen' => $this->imagen,
                'rol_id' => $this->rol_id,
            ]);

            return true;
        } catch (PDOException $e) {
            echo ' usermodel, en save, error pdo'.$e.' ';

            return false;
        }
    }

    public function getAll()
    {
        $items = [];
        try {
            $query = $this->query('SELECT * FROM usuarios');

            while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new UserModel();
                $item->setId($p['id']);
                $item->setNif($p['nif']);
                $item->setNombre($p['nombre']);
                $item->setApellidos($p['apellidos']);
                $item->setEmail($p['email']);
                $item->setPassword($p['password']);
                $item->setTelefono($p['telefono']);
                $item->setDireccion($p['direccion']);
                $item->setEstado($p['estado']);
                $item->setImagen($p['imagen']);
                $item->setRol_id($p['rol_id']);

                array_push($items, $item);
            }
        } catch (PDOException $e) {
            echo ' usermodel, en getAll, error pdo'.$e.' ';
            getMessage()->$e;

            return false;
        }
    }

    //fin getall

    public function get($id)
    {
        try {
            $query = $this->prepare('SELECT * FROM usuarios WHERE id = :id');
            $query->execute([
                'id' => $id,
            ]);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            $this->setId($user['id']);
            $this->setNif($user['nif']);
            $this->setNombre($user['nombre']);
            $this->setApellidos($user['apellidos']);
            $this->setEmail($user['email']);
            $this->setPassword($user['password']);
            $this->setTelefono($user['telefono']);
            $this->setDireccion($user['direccion']);
            $this->setEstado($user['estado']);
            $this->setImagen($user['imagen']);
            $this->setRol_id($user['rol_id']);

            return $this;
        } catch (PDOException $e) {
            echo ' usermodel, en get(id), error pdo'.$e.' ';
            getMessage()->$e;

            return false;
        }
    }

    public function delete($id)
    {
        try {
            $query = $this->prepare('DELETE FROM usuarios WHERE id = :id');
            $query->execute(['id=>$id']);

            return true;
        } catch (PDOException $e) {
            echo ' usermodel, en delete(id), error pdo'.$e.' ';
            getMessage()->$e;

            return false;
        }
    }

    public function update()
    {
        try {
            $query = $this->prepare('UPDATE usuarios SET nif = :nif,nombre = :nombre,apellidos = :apellidos ,email = :email,
                                    password = :password,telefono = :telefono,direccion = :direcion,estado = :estado,
                                    imagen = :imagen,rol_id = :rol_id WHERE id = :id');
            $query->execute([
                'id' => $this->id,
                'nif' => $this->nif,
                'nombre' => $this->nombre,
                'apellidos' => $this->apellidos,
                'email' => $this->email,
                'password' => $this->password,
                'telefono' => $this->telefono,
                'direccion' => $this->direccion,
                'estado' => $this->estado,
                'imagen' => $this->imagen,
                'rol_id' => $this->rol_id,
            ]);

            return true;
        } catch (PDOException $e) {
            echo ' usermodel, en get(id), error pdo'.$e.' ';
            getMessage()->$e;

            return false;
        }
    }

    public function from($array)
    {
        $this->id = $array['id'];
        $this->nif = $array['nif'];
        $this->nombre = $array['nombre'];
        $this->apellidos = $array['apellidos'];
        $this->email = $array['email'];
        $this->password = $array['password'];
        $this->telefono = $array['telefono'];
        $this->direccion = $array['direccion'];
        $this->estado = $array['estado'];
        $this->imagen = $array['imagen'];
        $this->rol_id = $array['rol_id'];
    }

    public function exist($email)
    {
        try {
            $query = $this->prepare('SELECT email FROM usuarios WHERE email = :email');
            $query->execute(['email' => $email]);

            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo ' usermodel, en get(id), error pdo'.$e.' ';
            getMessage()->$e;

            return false;
        }
    }

    //fin existe usuario

    public function comparePasswords($password, $id)
    {
        try {
            $user = $this->get($id);

            return password_verify($password, $user->getPassword());
        } catch (PDOException $e) {
            echo ' usermodel, en get(id), error pdo'.$e.' ';
            getMessage()->$e;

            return false;
        }
    }

    private function getHashedPassword($password)
    {
        //encripta la contraseña, el cost es el numero de veces que la encripta
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNif($nif)
    {
        $this->nif = $nif;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $this->getHashedPassword($password);
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    public function setRol_id($rol_id)
    {
        $this->rol_id = $rol_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getRol_id()
    {
        return $this->rol_id;
    }
}
