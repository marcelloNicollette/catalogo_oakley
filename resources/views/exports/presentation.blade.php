<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $collection->name }} - Olympikus</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .logo {
            max-width: 250px;
            margin-bottom: 20px;
        }
        .collection-title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #1a202c;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        .product-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .product-image-container {
            position: relative;
            padding-top: 75%;
            overflow: hidden;
        }
        .product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .product-info {
            padding: 20px;
        }
        .product-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #2d3748;
        }
        .product-code {
            font-size: 16px;
            color: #718096;
            margin-bottom: 10px;
        }
        .product-price {
            font-size: 20px;
            color: #2c5282;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .product-description {
            font-size: 16px;
            color: #4a5568;
            line-height: 1.5;
            margin-bottom: 15px;
        }
        .product-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .tag {
            background-color: #ebf4ff;
            color: #2c5282;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Olympikus" class="logo">
        <h1 class="collection-title">{{ $collection->name }}</h1>
    </div>

    <div class="product-grid">
        @foreach($collection->products as $product)
            <div class="product-card">
                @if($product->image)
                    <div class="product-image-container">
                        <img src="{{ public_path($product->image) }}" alt="{{ $product->name }}" class="product-image">
                    </div>
                @endif

                <div class="product-info">
                    <h2 class="product-name">{{ $product->name }}</h2>
                    
                    @unless($remove_code)
                        <div class="product-code">Código: {{ $product->code }}</div>
                    @endunless

                    @unless($remove_price)
                        <div class="product-price">R$ {{ number_format($product->price, 2, ',', '.') }}</div>
                    @endunless

                    @unless($remove_description)
                        <div class="product-description">{{ $product->description }}</div>
                    @endunless

                    @unless($remove_tag)
                        @if($product->tags)
                            <div class="product-tags">
                                @foreach($product->tags as $tag)
                                    <span class="tag">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif
                    @endunless
                </div>
            </div>

            @if($loop->iteration % 6 == 0 && !$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach
    </div>
</body>
</html>