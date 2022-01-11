<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(UsersSeeder::class);
        $this->call(EstadosSeeder::class);
        $this->call(EstadosEmpleadosSeeder::class);
        $this->call(NegocioSeeder::class);
        $this->call(TipoClienteSeeder::class);
        $this->call(PuestoSeeder::class);
        $this->call(EmpleadoSeeder::class);
        $this->call(FormaPagoSeeder::class);
        $this->call(TipoTrabajoSeeder::class);
        $this->call(EstadosTallerSeeder::class);
        $this->call(UbicacionEquipoSeeder::class);
        $this->call(EquipoSeeder::class);
        $this->call(TipoTransaccionSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(ServicioSeeder::class);
        $this->call(EstadoCajaSeeder::class);
        $this->call(TipoMovimientoSeeder::class);
        $this->call(TipoCuentaSeeder::class);
        $this->call(BancoSeeder::class);
        $this->call(CuentaBancariaSeeder::class);
        $this->call(EstadoChequeSeeder::class);
        $this->call(ChequeSeeder::class);
        $this->call(EstadoEnvioSeeder::class);
        //$this->call(RutasVendedorSeeder::class);
        $this->call(ClienteSeeder::class);
        // $this->call(OrdenEquipoSeeder::class);
        //$this->call(RegistroEnvioSeeder::class);
        $this->call(EstadoOrdenesSeeder::class);
        $this->call(TipoTransaccionCargoAbonoSeeder::class);
        $this->call(DocumentoSeeder::class);
        $this->call(MovIngresoEgresoSeeder::class);
        $this->call(TipoCalculoSeeder::class);
        $this->call(ValoresPorCalculadoSeeder::class);
        $this->call(ValoresFijoSeeder::class);
        $this->call(EstadoPlanillaSeeder::class);
        //$this->call(FacturacionSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');        
    }
}
 