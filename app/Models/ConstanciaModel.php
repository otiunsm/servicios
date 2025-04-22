<?php

namespace App\Models;

use CodeIgniter\Model;

class ConstanciaModel extends Model
{
    protected $table = 'cc_tramite';
    protected $primaryKey = 'CodigoTramite';

    public function getConstanciasServerSide($limit, $offset, $search, $expediente = null, $escuela = null)
    {
        $builder = $this->db->table('cc_tramite AS t')
            ->select('
                t.CodigoAlumnoSira,
                t.Alumno,
                tc.TipoConstancia,
                tc.CodigoTipoConstancia,
                ep.DescripcionEscuela AS EscuelaProfesional,
                t.CodigoTramite,
                c.NroExpediente AS NroExpedienteConstancia,
                t.NroExpediente AS NroExpedienteTramite,
                c.FechaAtencion
            ')
            ->join('cc_constancias AS c', 't.CodigoTramite = c.CodigoTramite', 'left')
            ->join('cc_tipoconstancia AS tc', 'c.CodigoTipoConstancia = tc.CodigoTipoConstancia', 'left')
            ->join('escuelaprofesional AS ep', 't.CodigoEscuela = ep.CodigoEscuela', 'left')
            ->where('c.Constancia IS NOT NULL')
            ->where('c.Constancia !=', 'DATOS EN SISTEMA SIGA')
            ->where('c.Constancia !=', 'nada')
            ->where('t.Alumno IS NOT NULL')
            ->where('t.Alumno !=', '')
            ->whereNotIn('c.CodigoTipoConstancia', [11, 12, 13, 17, 36, 39, 42])
            ->whereNotIn('t.CodigoEscuela', ['0403', '0605', '0610', '0802']) // Excluir escuelas inactivas
            ->groupStart()
                ->where('c.NroExpediente IS NOT NULL')
                ->where('c.NroExpediente !=', '')
                ->where('c.NroExpediente !=', '00000')
            ->groupEnd();

        if (!empty($search)) {
            $builder->groupStart()
                ->like('t.CodigoAlumnoSira', $search)
                ->orLike('t.Alumno', $search)
                ->orLike('tc.TipoConstancia', $search)
                ->orLike('ep.DescripcionEscuela', $search)
                ->orLike('c.NroExpediente', $search)
                ->orLike('t.NroExpediente', $search)

                ->groupEnd();
        }

        if (!empty($expediente)) {
            $builder->groupStart()
            ->like("CONCAT(c.NroExpediente, ' - ', t.NroExpediente)", $expediente)
                ->groupEnd();
        }

        if (!empty($escuela)) {
            $builder->where('t.CodigoEscuela', $escuela);
        }

        return $builder->limit($limit, $offset)->get()->getResultArray();
    }

    public function getTotalConstancias($search, $expediente = null, $escuela = null)
    {
        $builder = $this->db->table('cc_tramite AS t')
            ->join('cc_constancias AS c', 't.CodigoTramite = c.CodigoTramite', 'left')
            ->join('cc_tipoconstancia AS tc', 'c.CodigoTipoConstancia = tc.CodigoTipoConstancia', 'left')
            ->join('escuelaprofesional AS ep', 't.CodigoEscuela = ep.CodigoEscuela', 'left')
            ->where('c.Constancia IS NOT NULL')
            ->where('c.Constancia !=', 'DATOS EN SISTEMA SIGA')
            ->where('c.Constancia !=', 'nada')
            ->where('t.Alumno IS NOT NULL')
            ->where('t.Alumno !=', '')
            ->whereNotIn('c.CodigoTipoConstancia', [11, 12, 13, 17, 36, 39, 42])
            ->whereNotIn('t.CodigoEscuela', ['0403', '0605', '0610', '0802']); // Excluir escuelas inactivas

        if (!empty($search)) {
            $builder->groupStart()
                ->like('t.CodigoAlumnoSira', $search)
                ->orLike('t.Alumno', $search)
                ->orLike('tc.TipoConstancia', $search)
                ->orLike('ep.DescripcionEscuela', $search)
                ->orLike('c.NroExpediente', $search)
                ->orLike('t.NroExpediente', $search)
                ->groupEnd();
        }

        if (!empty($expediente)) {
            $builder->groupStart()
            ->like("CONCAT(c.NroExpediente, ' - ', t.NroExpediente)", $expediente)
                ->groupEnd();
        }

        if (!empty($escuela)) {
            $builder->where('ep.CodigoEscuela', $escuela);
        }

        return $builder->countAllResults();
    }

    public function getConstanciaByCodigo($codigoTramite, $codigoTipoConstancia)
    {
        return $this->db->table('cc_constancias AS c')
            ->select('
                c.Constancia,
                c.NroExpediente AS NroExpedienteConstancia,
                t.NroExpediente AS NroExpedienteTramite,
                t.CodigoAlumnoSira,
                c.FechaAtencion,
                tc.Cabecera,
                tc.TipoConstancia
            ')
            ->join('cc_tramite AS t', 'c.CodigoTramite = t.CodigoTramite', 'left')
            ->join('cc_tipoconstancia AS tc', 'c.CodigoTipoConstancia = tc.CodigoTipoConstancia', 'left')
            ->where('c.CodigoTramite', $codigoTramite)
            ->where('c.CodigoTipoConstancia', $codigoTipoConstancia)
            ->get()->getRowArray();
    }

    public function getEscuelasProfesionales()
    {
        return $this->db->table('escuelaprofesional')
            ->select('CodigoEscuela, DescripcionEscuela')
            ->orderBy('DescripcionEscuela', 'ASC')
            ->get()->getResultArray();
    }
}
