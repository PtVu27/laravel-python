<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::create(['name' => 'Admin Pro', 'email' => 'admin@pickleballpro.vn', 'password' => '123456', 'role' => 'admin']);
        User::create(['name' => 'Khách hàng mẫu', 'email' => 'user@pickleballpro.vn', 'password' => '123456', 'role' => 'customer']);

        // Categories
        $c1 = Category::create(['name' => 'Vợt Pickleball']);
        $c2 = Category::create(['name' => 'Bóng Pickleball']);
        $c3 = Category::create(['name' => 'Giày Thể Thao']);
        $c4 = Category::create(['name' => 'Phụ Kiện']);

        // Products
        $products = [
            ['name'=>'Joola Ben Johns Hyperion CFS 16','description'=>'Vợt pickleball carbon fiber chuyên nghiệp, thiết kế đặc biệt cho phong cách chơi mạnh mẽ và chính xác.','price'=>4500000,'quantity'=>25,'category_id'=>$c1->id,'image'=>'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?w=400&h=400&fit=crop'],
            ['name'=>'Selkirk Amped Epic','description'=>'Vợt polymer core công nghệ X5 FiberFlex, mang đến cảm giác kiểm soát bóng tuyệt vời.','price'=>3800000,'quantity'=>30,'category_id'=>$c1->id,'image'=>'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=400&fit=crop'],
            ['name'=>'Engage Pursuit Pro MX','description'=>'Vợt pickleball mặt grit texture, tối ưu cho spin và power shots.','price'=>5200000,'quantity'=>15,'category_id'=>$c1->id,'image'=>'https://images.unsplash.com/photo-1587280501635-68a0e82cd5ff?w=400&h=400&fit=crop'],
            ['name'=>'Head Radical Elite','description'=>'Vợt composite nhẹ, phù hợp cho người mới bắt đầu và trung cấp.','price'=>2900000,'quantity'=>40,'category_id'=>$c1->id,'image'=>'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=400&h=400&fit=crop'],
            ['name'=>'Franklin X-40 Outdoor Balls','description'=>'Bóng outdoor chính hãng USAPA approved, 12 quả/hộp. Bền bỉ, bay ổn định.','price'=>850000,'quantity'=>100,'category_id'=>$c2->id,'image'=>'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400&h=400&fit=crop'],
            ['name'=>'Dura Fast 40 Balls','description'=>'Bóng thi đấu chuyên nghiệp, tiêu chuẩn giải đấu, 6 quả/hộp.','price'=>650000,'quantity'=>80,'category_id'=>$c2->id,'image'=>'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=400&h=400&fit=crop'],
            ['name'=>'Onix Pure 2 Indoor','description'=>'Bóng indoor 26 lỗ, bay nhẹ và dễ kiểm soát, 3 quả/hộp.','price'=>420000,'quantity'=>60,'category_id'=>$c2->id,'image'=>'https://images.unsplash.com/photo-1471295253337-3ceaaedca402?w=400&h=400&fit=crop'],
            ['name'=>'ASICS Gel-Renma','description'=>'Giày pickleball chuyên dụng, đế gel giảm chấn, bám sân tốt.','price'=>2800000,'quantity'=>35,'category_id'=>$c3->id,'image'=>'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop'],
            ['name'=>'K-Swiss Express Light','description'=>'Giày thể thao nhẹ, thoáng khí, phù hợp chơi pickleball indoor/outdoor.','price'=>2200000,'quantity'=>45,'category_id'=>$c3->id,'image'=>'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=400&h=400&fit=crop'],
            ['name'=>'Nike Court Vapor Lite 2','description'=>'Giày tennis/pickleball cao cấp Nike, đệm Air thoải mái suốt trận đấu.','price'=>3500000,'quantity'=>20,'category_id'=>$c3->id,'image'=>'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400&h=400&fit=crop'],
            ['name'=>'Selkirk Premium Paddle Bag','description'=>'Túi đựng vợt cao cấp, chứa được 3 vợt, nhiều ngăn tiện dụng.','price'=>1200000,'quantity'=>50,'category_id'=>$c4->id,'image'=>'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=400&fit=crop'],
            ['name'=>'Tourna Grip Overgrip 10-Pack','description'=>'Cuốn cán vợt chống mồ hôi, dry feel, 10 cuốn/gói.','price'=>350000,'quantity'=>200,'category_id'=>$c4->id,'image'=>'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=400&h=400&fit=crop'],
        ];

        foreach ($products as $p) {
            Product::create(array_merge($p, ['view' => rand(50, 500)]));
        }
    }
}
