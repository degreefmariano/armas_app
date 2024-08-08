<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
class User extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;
    use HasApiTokens;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';
    public const COD_ROL = 1;
    public const COD_ESTADO_USR = 1;
    public const COD_PERS_POL = 1;
    

    protected $fillable = [
        'email',
        'password',
        'legajo',
        'documento',
        'cuil',
        'name',
        'grado',
        'cod_ud',
        'cod_subud',
        'fecha_alta',
        'rol',
        'estado_usr',
        'obs_usr',
        'personal_policial',
        'vencimiento',
        'cod_usr',
        'habilita_sist_usr',
        'deleted_at',
        'id_localidad',
        'last_activity'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function unidad(): BelongsTo
    {
        return $this->belongsTo(Unidad::class, 'cod_ud');
    }

    public function localidad(): BelongsTo
    {
        return $this->belongsTo(Localidad::class, 'id_localidad');
    }

    public function personal(): BelongsTo
    {
        return $this->belongsTo(Personal::class, 'legajo');
    }

    public function subUnidad(): BelongsTo
    {
        return $this->belongsTo(Subunidad::class, 'cod_subud');
    }

    public function isAdministrator()
    {
        return auth('sanctum')->user()->id = 1 ? true : false;
    }

    public static function datosUser($id_usr)
    {
        return User::select('id', 'name', 'email')
            ->where('id', $id_usr)
            ->first();
        
    }

    public static function getUregional($cod_ureg)
    {
        return DB::table('uregional')
            ->where('cod_uregional', $cod_ureg)
            ->first()->nom_uregional;
    }


    public function Rol()
    {
        return $this->belongsTo(Rol::class, 'rol');
    }

    public function setNameAttribute($atributo)
    {
        //pone en mayuscula el nombre
        $this->attributes['name'] = strtoupper($atributo);
    }

    public function setEmailAttribute($atributo)
    {
        //pone en mayuscula el email
        $this->attributes['email'] = strtoupper($atributo);
    }

    public function setObsUsrAttribute($atributo)
    {
         //pone en mayuscula las observaciones
         $this->attributes['obs_usr'] = strtoupper($atributo);
    }

    public function seccional()
    {
        return $this->belongsTo(Seccional::class, 'cod_secc_usr', 'cod_seccional');
    }
    public function uregional()
    {
        return $this->belongsTo('App\Models\UnidadRegional', 'cod_ureg_usr', 'cod_uregional');
    }

    public static function datosLegajo($id, $legajo)
    {   
        switch ($id) {
            case 8:
                $legajo = '565504';
                break;
            case 9:
                $legajo = '575941';
                break;
            case 10:
                $legajo = '519197';
                break;
            case 11:
                $legajo = '579157';
                break;
            case 12:
                $legajo = '579131';
                break;
            case 13:
                $legajo = '542237';
                break;
            case 22:
                $legajo = '629618';
                break;
            case 23:
                $legajo = '587818';
                break;
            case 24:
                $legajo = '587818';
                break;
            case 25:
                $legajo = '509183';
                break;
            case 27:
                $legajo = '573485';
                break;
            case 29:
                $legajo = '588423';
                break;
            case 31:
                $legajo = '629049';
                break;
            case 32:
                $legajo = '111111'; //DIVISION INFORMATICA
                break;
            case 33:
                $legajo = '598569';
                break;
            case 34:
                $legajo = '600890';
                break;
            case 35:
                $legajo = '562246';
                break;
            case 36:
                $legajo = '552682';
                break;
            case 37:
                $legajo = '649023';
                break;
            case 39:
                $legajo = '582859';
                break;
            case 40:
                $legajo = '521469';
                break;
            case 41:
                $legajo = '572268';
                break;
            case 42:
                $legajo = '551198';
                break;
            case 43:
                $legajo = '491951';
                break;
            case 44:
                $legajo = '598241';
                break;
            case 45:
                $legajo = '583090';
                break;
            case 47:
                $legajo = '531405';
                break;
            case 48:
                $legajo = '626066';
                break;
            case 49:
                $legajo = '625931';
                break;
            case 50:
                $legajo = '541117';
                break;
            case 51:
                $legajo = '518697';
                break;
            case 52:
                $legajo = '642037';
                break;
            case 53:
                $legajo = '558516';
                break;
            case 54:
                $legajo = '559911';
                break;
            case 55:
                $legajo = '602523';
                break;
            case 56:
                $legajo = '603660';
                break;
            case 57:
                $legajo = '609161';
                break;
            case 58:
                $legajo = '603198';
                break;
            case 59:
                $legajo = '559253';
                break;
            case 60:
                $legajo = '615293';
                break;
            case 61:
                $legajo = '686174';
                break;
            case 62:
                $legajo = '540226';
                break;
            case 63:
                $legajo = '492671';
                break;
            case 64:
                $legajo = '637548';
                break;
            case 65:
                $legajo = '490296';
                break;
            case 66:
                $legajo = '522864';
                break;
            case 67:
                $legajo = '522091';
                break;
            case 68:
                $legajo = '576085';
                break;
            case 69:
                $legajo = '579947';
                break;
            case 70:
                $legajo = '547247';
                break;
            case 71:
                $legajo = '574767';
                break;
            case 72:
                $legajo = '631272';
                break;
            case 73:
                $legajo = '549193';
                break;
            case 74:
                $legajo = '629073';
                break;
            case 75:
                $legajo = '612405';
                break;
            case 76:
                $legajo = '521426';
                break;
            case 77:
                $legajo = '628751';
                break;
            case 78:
                $legajo = '518522';
                break;
            case 79:
                $legajo = '574520';
                break;
            case 81:
                $legajo = '497126';
                break;
            case 82:
                $legajo = '592111';
                break;
            case 83:
                $legajo = '619388';
                break;
            case 84:
                $legajo = '625931';
                break;
            case 85:
                $legajo = '714003';
                break;
            case 86:
                $legajo = '573485';
                break;
            case 87:
                $legajo = '551732';
                break;
            case 88:
                $legajo = '511200';
                break;
            case 89:
                $legajo = '669482';
                break;
            case 90:
                $legajo = '579319';
                break;
            case 91:
                $legajo = '522864';
                break;
            case 92:
                $legajo = '222222'; //PRUEBA
                break;
            }
        return $legajo;
    }

    public static function index(Request $request)
    {
        return User::select(
            'users.id',
            'users.legajo',
            'users.email',
            'users.documento',
            'users.name',
            'users.cod_ud',
            'users.cod_subud',
            'users.fecha_alta',
            'users.rol',
            'users.estado_usr',
            'users.obs_usr',
            'users.vencimiento',
            'users.id_localidad'
        )
        ->join('roles', function ($join) {
            $join->on('roles.id', '=', 'users.rol');
        })
        // ->when(!is_null($request->fecha_desde), function ($query) use ($request) {
        //     return $query->whereBetween('created_at', [$request->fecha_desde,$request->fecha_hasta]);
        // })
        ->when(!is_null($request->cod_ud), function ($query) use ($request) {
            return $query->where('cod_ud', $request->cod_ud);
        })
        ->when(!is_null($request->cod_subud), function ($query) use ($request) {
            return $query->where('cod_subud', $request->cod_subud);
        })
        ->when(!is_null($request->legajo), function ($query) use ($request) {
            return $query->where('legajo', $request->legajo);
        })
        ->when(!is_null($request->name), function ($query) use ($request) {
            return $query->where('name', $request->name);
        })
        ->when(!is_null($request->estado_usr), function ($query) use ($request) {
            return $query->where('estado_usr', $request->estado_usr);
        })
        ->where('personal_policial','true')
        ->orderBy('users.name')->paginate($request->offset ?? 20);
    }

    public static function store(Request $request)
    {
        // $latestId = User::latest('id')->first()->id + 1;
        // $usuario = 'USUARIO' . $latestId;
        $usuario = $request->usuario;

        $email = strtoupper($usuario. config('constants.DOMINIO_MAIL_USERS'));
        // dd('entró al modelo: ' . $email);

        $personal = Personal::select('ndoc_ps', 'cuil_ps')->where('nlegajo_ps', $request->legajo)->first();

        $user = User::create([
            'email'             => $email,
            'password'          => Hash::make($request->legajo),
            //FRONT: DATOS DEL PERSONAL
            'legajo'            => $request->legajo,
            'documento'         => $personal->ndoc_ps,
            'cuil'              => $personal->cuil_ps,
            'name'              => $request->name,
            'cod_ud'            => $request->unidad,
            'cod_subud'         => $request->subunidad,
            //FRONT: DATOS DEL USUARIO
            'fecha_alta'        => Carbon::now()->format('d-m-y H:m:s'),
            'rol'               => $request->rol,
            'estado_usr'        => User::COD_ESTADO_USR,
            'obs_usr'           => $request->observacion,        
            'personal_policial' => true,
            'id_localidad'      => $request->localidad,
            'vencimiento'       => Carbon::now()->subDay(1)->format('Y-m-d'),
            
        ]);
        //$token    = $user->createToken('auth_token')->plainTextToken; //esta línea loguea al usuario nuevo
        $user_registro = auth('sanctum')->user(); // Usuario que está haciendo el cambio
        $newDataJson = json_encode($user->toArray());

        AuditoriaGestionUsuario::create([
            'user_id' => $user_registro->id,
            'action' => 'creacion',
            'new_data' => $newDataJson,
        ]);
        return $user;
    }

    public static function updateUser(Request $request)
    {
        $user = User::findOrfail($request->id);

        $emailSinEspacios = str_replace(' ', '', $request->email);
        // $this->merge([
        //     'email' => strtoupper($nombreSinEspacios. config('constants.DOMINIO_MAIL_USERS'))]);

        $oldData = $user->toArray();
        $user->fill([
            'legajo'     => $request->legajo,
            'name'       => $request->usuario,
            'email'      => $emailSinEspacios,
            'documento'  => $request->documento,
            'cod_ud'     => $request->cod_ud,
            'cod_subud'  => $request->cod_subud,
            'obs_usr'    => $request->obs_usr,
            'estado_usr' => $request->estado_usr,
            'rol'        => $request->rol,
            'fecha_alta' => $request->fecha_alta,
            'id_localidad' => $request->localidad,
        ]);        
        $user->save();
        $user_registro = auth('sanctum')->user(); // Usuario que está haciendo el cambio
        $oldDataJson = json_encode($oldData);
        $newDataJson = json_encode($user->toArray());
        AuditoriaGestionUsuario::create([
            'user_id' => $user_registro->id,
            'action' => 'modificacion',
            'old_data' => $oldDataJson,
            'new_data' => $newDataJson,
        ]);
        return $user;
    }

    public static function cambiarPassword(Request $request)
    {
        $user = auth('sanctum')->user();
        $newPasswordHash = Hash::make($request->newPassword);
        $fechaVencimiento = Carbon::now()->addDays(60)->format('Y-m-d');
        $user->update([
        'password' => $newPasswordHash,
        'vencimiento' => $fechaVencimiento
        ]);
        return $user;
    }

    public static function blanquearPassword(Request $request)
    {
        $blanqueoPass = Hash::make($request->legajo);
        $user = User::where('legajo', $request->legajo)->first();
        $oldData = $user->toArray();
        $user->update([
            'password' => $blanqueoPass,
            'vencimiento' => Carbon::now()->subDays(1)->format('Y-m-d'),
        ]);
        $user_registro = auth('sanctum')->user();
        $oldDataJson = json_encode($oldData);
        $newDataJson = json_encode($user->toArray());
        AuditoriaGestionUsuario::create([
            'user_id' => $user_registro->id,
            'action' => 'blanqueo',
            'old_data' => $oldDataJson,
            'new_data' => $newDataJson,
        ]);
        return $user;
    }
}
