
import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { ArrowRight, Star, Truck, Shield, Headphones } from 'lucide-react';
import Layout from '@/components/Layout';
import ProductCard from '@/components/ProductCard';
import { products } from '@/data/products';
import { useCart } from '@/hooks/useCart';
import { toast } from '@/hooks/use-toast';

const Index = () => {
  const { addItem } = useCart();

  const featuredProducts = products.slice(0, 3);

  const handleAddToCart = (product: any) => {
    addItem(product);
    toast({
      title: "Added to cart",
      description: `${product.name} has been added to your cart.`,
    });
  };

  return (
    <Layout>
      {/* Hero Section */}
      <section className="relative bg-gradient-to-r from-blue-900 via-gray-900 to-black text-white">
      <div className="absolute inset-0 bg-black/50"></div> {/* Sedikit lebih gelap agar teks lebih kontras */}
      <div className="relative container mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div className="max-w-3xl">
          <Badge className="mb-4 bg-blue-500/80 text-white border-blue-600/50"> {/* Badge dengan warna biru yang lebih dalam */}
            New Collection
          </Badge>
          <h1 className="text-4xl md:text-6xl font-bold mb-6 leading-tight">
            Discover Premium
            <span className="block bg-gradient-to-r from-blue-300 to-blue-500 bg-clip-text text-transparent"> {/* Gradien biru untuk teks highlight */}
              Shopping Experience
            </span>
          </h1>
          <p className="text-xl mb-8 text-gray-200"> {/* Teks paragraf sedikit lebih abu-abu agar tidak terlalu kontras */}
            Explore our curated collection of premium products with unbeatable quality and style.
          </p>
          <div className="flex flex-col sm:flex-row gap-4">
            <Link href="/products">
              <Button size="lg" className="bg-blue-600 text-white hover:bg-blue-700"> {/* Tombol utama Shop Now menjadi biru */}
                Shop Now
                <ArrowRight className="ml-2 h-5 w-5" />
              </Button>
            </Link>
            <Link href="/categories">
              <Button size="lg" variant="outline" className="border-white text-white hover:bg-white/20"> {/* Tombol Browse Categories dengan outline putih */}
                Browse Categories
              </Button>
            </Link>
          </div>
        </div>
      </div>
    </section>

      {/* Features Section */}
      <section className="py-16 bg-muted/30">
        <div className="container mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <Card className="text-center border-0 shadow-sm">
              <CardContent className="pt-6">
                <div className="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                  <Truck className="h-6 w-6 text-blue-600" />
                </div>
                <h3 className="font-semibold mb-2">Free Shipping</h3>
                <p className="text-muted-foreground">Free shipping on orders over $50</p>
              </CardContent>
            </Card>

            <Card className="text-center border-0 shadow-sm">
              <CardContent className="pt-6">
                <div className="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                  <Shield className="h-6 w-6 text-green-600" />
                </div>
                <h3 className="font-semibold mb-2">Secure Payment</h3>
                <p className="text-muted-foreground">100% secure payment processing</p>
              </CardContent>
            </Card>

            <Card className="text-center border-0 shadow-sm">
              <CardContent className="pt-6">
                <div className="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                  <Headphones className="h-6 w-6 text-purple-600" />
                </div>
                <h3 className="font-semibold mb-2">24/7 Support</h3>
                <p className="text-muted-foreground">Round-the-clock customer support</p>
              </CardContent>
            </Card>
          </div>
        </div>
      </section>

      {/* Featured Products */}
      <section className="py-16">
        <div className="container mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">Featured Products</h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              Discover our hand-picked selection of premium products that combine quality, style, and value.
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            {featuredProducts.map((product) => (
              <ProductCard
                key={product.id}
                product={product}
                onAddToCart={handleAddToCart}
              />
            ))}
          </div>

          <div className="text-center">
            <Link href="/products">
              <Button size="lg" className="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                View All Products
                <ArrowRight className="ml-2 h-5 w-5" />
              </Button>
            </Link>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-16 bg-gradient-to-r from-gray-900 to-gray-800 text-white">
        <div className="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl md:text-4xl font-bold mb-4">
            Ready to Start Shopping?
          </h2>
          <p className="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
            Join thousands of satisfied customers and discover premium products at unbeatable prices.
          </p>
          <Link href="/products">
            <Button size="lg" className="bg-white text-gray-900 hover:bg-gray-100">
              Start Shopping Now
              <ArrowRight className="ml-2 h-5 w-5" />
            </Button>
          </Link>
        </div>
      </section>
    </Layout>
  );
};

export default Index;
