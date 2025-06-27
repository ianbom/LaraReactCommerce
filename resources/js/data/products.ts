
import { Product } from '@/hooks/useCart';

export const products: Product[] = [
  {
    id: 1,
    name: "Premium Wireless Headphones",
    price: 299.99,
    image: "https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=500&fit=crop",
    category: "Electronics",
    brand: "AudioTech",
    rating: 4.8,
    reviews: 124,
    description: "High-quality wireless headphones with noise cancellation and 30-hour battery life.",
    inStock: true
  },
  {
    id: 2,
    name: "Smart Fitness Watch",
    price: 199.99,
    image: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop",
    category: "Electronics",
    brand: "FitTech",
    rating: 4.6,
    reviews: 89,
    description: "Advanced fitness tracking with heart rate monitor, GPS, and 7-day battery life.",
    inStock: true
  },
  {
    id: 3,
    name: "Designer Leather Jacket",
    price: 459.99,
    image: "https://images.unsplash.com/photo-1551028719-00167b16eac5?w=500&h=500&fit=crop",
    category: "Apparel",
    brand: "StyleCo",
    rating: 4.9,
    reviews: 67,
    description: "Premium genuine leather jacket with classic design and perfect fit.",
    inStock: true
  },
  {
    id: 4,
    name: "Professional Camera Lens",
    price: 799.99,
    image: "https://images.unsplash.com/photo-1606983340126-99ab4feaa64a?w=500&h=500&fit=crop",
    category: "Electronics",
    brand: "PhotoPro",
    rating: 4.7,
    reviews: 156,
    description: "High-performance 85mm f/1.4 lens for professional photography.",
    inStock: false
  },
  {
    id: 5,
    name: "Ergonomic Office Chair",
    price: 349.99,
    image: "https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=500&h=500&fit=crop",
    category: "Furniture",
    brand: "ComfortMax",
    rating: 4.5,
    reviews: 203,
    description: "Premium ergonomic office chair with lumbar support and adjustable height.",
    inStock: true
  },
  {
    id: 6,
    name: "Luxury Handbag",
    price: 599.99,
    image: "https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&h=500&fit=crop",
    category: "Apparel",
    brand: "LuxeStyle",
    rating: 4.8,
    reviews: 92,
    description: "Elegant designer handbag crafted from premium materials.",
    inStock: true
  }
];

export const categories = [
  { name: "Electronics", count: 3 },
  { name: "Apparel", count: 2 },
  { name: "Furniture", count: 1 }
];

export const brands = [
  { name: "AudioTech", count: 1 },
  { name: "FitTech", count: 1 },
  { name: "StyleCo", count: 1 },
  { name: "PhotoPro", count: 1 },
  { name: "ComfortMax", count: 1 },
  { name: "LuxeStyle", count: 1 }
];
