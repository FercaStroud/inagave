declare interface Product {
  id: number;
  user_id: number;
  estate: string;
  size: string;
  age: number;
  quantity: number;
  price: any;
  maintenance_price: any;
  available: boolean;
  jimado_at: any;
  planted_at: any;
  municipality: string;
  location: string;
  location_url: string;
  description: string;
  user: User;
  selectedPrice: string;
}
