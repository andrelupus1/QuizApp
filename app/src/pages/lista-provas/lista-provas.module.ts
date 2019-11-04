import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { ListaProvasPage } from './lista-provas';

@NgModule({
 /*  declarations: [
    ListaProvasPage,
  ], */
  imports: [
    IonicPageModule.forChild(ListaProvasPage),
  ],
})
export class ListaProvasPageModule {}
