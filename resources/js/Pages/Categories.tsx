
import { Link } from '@inertiajs/react';
import { ArrowRight } from 'lucide-react';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import Layout from '@/components/Layout';
import { categories, products } from '@/data/products';

const Categories = () => {
  const getCategoryImage = (categoryName: string) => {
    const categoryProduct = products.find(p => p.category === categoryName);
    return categoryProduct?.image || 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=500&h=500&fit=crop';
  };

  return (
    <Layout>
      <div className="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {/* Header */}
        <div className="text-center mb-12">
          <h1 className="text-4xl font-bold mb-4">Shop by Category</h1>
          <p className="text-muted-foreground max-w-2xl mx-auto">
            Explore our diverse range of product categories to find exactly what you're looking for.
          </p>
        </div>

        {/* Categories Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {categories.map((category) => (
            <Link
              key={category.name}
              href={`/products?category=${encodeURIComponent(category.name)}`}
            >
              <Card className="group hover:shadow-xl transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                <CardContent className="p-0">
                  <div className="relative">
                    <img
                      src={getCategoryImage(category.name)}
                      alt={category.name}
                      className="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500"
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent" />
                    <div className="absolute bottom-0 left-0 right-0 p-6 text-white">
                      <h3 className="text-2xl font-bold mb-2">{category.name}</h3>
                      <p className="text-sm opacity-90">
                        {category.count} {category.count === 1 ? 'product' : 'products'}
                      </p>
                    </div>
                  </div>

                  <div className="p-6">
                    <Button
                      variant="ghost"
                      className="w-full group-hover:bg-primary group-hover:text-primary-foreground transition-colors"
                    >
                      Explore {category.name}
                      <ArrowRight className="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform" />
                    </Button>
                  </div>
                </CardContent>
              </Card>
            </Link>
          ))}
        </div>

        {/* Featured Category Banner */}
        <div className="mt-16">
          <Card className="bg-gradient-to-r from-blue-600 to-purple-600 text-white overflow-hidden">
            <CardContent className="p-0">
              <div className="grid grid-cols-1 lg:grid-cols-2 items-center">
                <div className="p-8 lg:p-12">
                  <h2 className="text-3xl font-bold mb-4">
                    New Electronics Collection
                  </h2>
                  <p className="text-blue-100 mb-6">
                    Discover the latest in cutting-edge technology with our premium electronics collection.
                    From smart devices to audio equipment, find everything you need.
                  </p>
                  <Link href="/products?category=Electronics">
                    <Button size="lg" className="bg-white text-blue-600 hover:bg-gray-100">
                      Shop Electronics
                      <ArrowRight className="ml-2 h-5 w-5" />
                    </Button>
                  </Link>
                </div>
                <div className="relative h-64 lg:h-full">
                  <img
                    src="https://images.unsplash.com/photo-1468495244123-6c6c332eeece?w=600&h=400&fit=crop"
                    alt="Electronics"
                    className="w-full h-full object-cover"
                  />
                </div>
              </div>
            </CardContent>
          </Card>
        </div>
      </div>
    </Layout>
  );
};

export default Categories;
