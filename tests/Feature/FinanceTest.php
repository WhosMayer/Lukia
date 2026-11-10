<?php
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
class FinanceTest extends TestCase {
 use RefreshDatabase;
 private function category($user): int { return DB::table('categories')->insertGetId(['user_id'=>$user->id,'name'=>'Prueba']); }
 private function data($id): array {return ['category_id'=>$id,'type'=>'income','amount'=>'1234.56','date'=>'2026-10-29','description'=>'Ingreso prueba'];}
 public function test_registration_creates_private_categories_and_session(): void {
  $this->post('/registro',['name'=>'Mayer','email'=>'test@example.test','password'=>'Password123!','password_confirmation'=>'Password123!'])->assertRedirect('/panel');
  $this->assertAuthenticated(); $this->assertDatabaseCount('categories',4); $this->get('/panel')->assertOk();
 }
 public function test_guest_cannot_read_or_write(): void {
  $this->get('/panel')->assertRedirect('/login'); $this->post('/movimientos',[])->assertRedirect('/login');
 }
 public function test_exact_amount_and_monthly_balance(): void {
  $user=User::factory()->create(); $cat=$this->category($user); $this->actingAs($user);
  $this->post('/movimientos',$this->data($cat))->assertSessionHasNoErrors();
  $this->assertDatabaseHas('transactions',['amount_cents'=>123456]);
  $this->post('/movimientos',array_replace($this->data($cat),['type'=>'expense','amount'=>'34.56']));
  $this->post('/movimientos',array_replace($this->data($cat),['amount'=>'999','date'=>'2026-09-01']));
  $this->get('/panel?month=2026-10')->assertOk()->assertViewHas('income',123456)->assertViewHas('expense',3456)->assertSee('1.200,00');
 }
 public function test_cross_account_access_is_blocked(): void {
  $owner=User::factory()->create(); $other=User::factory()->create(); $cat=$this->category($owner);
  $this->actingAs($owner)->post('/movimientos',$this->data($cat)); $id=DB::table('transactions')->value('id');
  $this->actingAs($other)->get('/panel?month=2026-10')->assertDontSee('Ingreso prueba');
  $this->post('/movimientos',$this->data($cat))->assertSessionHasErrors('category_id');
  $this->get('/movimientos/'.$id.'/editar')->assertNotFound();
  $this->put('/movimientos/'.$id,$this->data($cat))->assertNotFound();
  $this->delete('/movimientos/'.$id)->assertNotFound(); $this->assertDatabaseCount('transactions',1);
 }
 public function test_edit_delete_and_invalid_values(): void {
  $user=User::factory()->create();$cat=$this->category($user);$this->actingAs($user);
  foreach(['0','-1','1.234','1e3','1,000'] as $amount) $this->post('/movimientos',array_replace($this->data($cat),['amount'=>$amount]))->assertSessionHasErrors('amount');
  $this->post('/movimientos',$this->data($cat));$id=DB::table('transactions')->value('id');
  $this->get('/movimientos/'.$id.'/editar')->assertOk();
  $this->put('/movimientos/'.$id,array_replace($this->data($cat),['amount'=>'0.01']))->assertRedirect();
  $this->assertDatabaseHas('transactions',['amount_cents'=>1]);$this->delete('/movimientos/'.$id)->assertRedirect();$this->assertDatabaseCount('transactions',0);
 }
 public function test_login_logout_and_invalid_month(): void {
  $user=User::factory()->create(['password'=>'Password123!']);
  $this->post('/login',['email'=>$user->email,'password'=>'wrong'])->assertSessionHasErrors('email');
  $this->post('/login',['email'=>$user->email,'password'=>'Password123!'])->assertRedirect('/panel');
  $this->get('/panel?month=invalid')->assertSessionHasErrors('month');
  $this->post('/salir')->assertRedirect('/login');$this->assertGuest();
 }
}
