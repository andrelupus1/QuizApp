import { Pipe, PipeTransform } from '@angular/core';
/**
 * Generated class for the FilterTemasPipe pipe.
 *
 * See https://angular.io/api/core/Pipe for more info on Angular Pipes.
 */
 @Pipe({
  name: 'filterTemas',
})
export class FilterTemasPipe implements PipeTransform {
  /**
   * Takes a value and makes it lowercase.
   */
  transform(value: string, ...args) {

    console.log(value);
    //return value.toLowerCase();
    //return "Ola";
  }
}
