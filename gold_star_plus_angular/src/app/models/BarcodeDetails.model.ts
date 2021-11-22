
export class BarcodeDetails{
  barcode?: string;
  details?: {
    game_type_id: number,
    game_name: string,
    series_name: string,
    number_set: string,
    quantity: number
  }[];

}
