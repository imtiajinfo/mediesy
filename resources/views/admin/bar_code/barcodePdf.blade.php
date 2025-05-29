<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$data->name}}</title>
    <style>
        .barcode-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 0px;
        }

        .barcode-item {
            width: 100%;
            margin: 0px;
            border: 1px solid #e6e6e6;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: auto;

        }

        .barcode {
            padding: 12px 12px;
            color: #000c5d;
            border: 1px solid #000c5d;
            margin: 10px;
            align-items: center;
            background: white;
            width: 180px !important;
            height: 40px;
        }

    </style>
</head>
<body>
    <h2>Barcodes</h2>
    <span><b>Product Name: </b> {{ $data->name }}; </span>
    <span><b>Product ID: </b>{{ $data->id }}; </span>
    <span><b>Product Code: </b>{{ $data->code }}</span>

    @if(isset($barcodes) && count($barcodes) > 0)
    <div class="barcode-container">

        <div class="barcode-item">
            @foreach ($barcodes as $barcode)

            {{-- <barcode code="{{$barcode}}" type="c39" class="barcode" format="CODE39" barWidthRatio="1" height="1" fontSize="5" displayValue="true" fontOptions="normal" textColor="#000000" lineColor="#000000" background="#FFFFFF" textAlign="center" validCheckCharacter="true" checkCharacterText="true" startChar="*" stopChar="*" barHeightRatio="1" /> --}}
            {{-- <barcode code="C-123456345" type="CODABAR" /> --}}
            {{-- {!!$barcode!!} --}}

            <img class="barcode" src="data:image/png;base64,{{ DNS1D::getBarcodePNG(strtoupper($barcode), 'C39+',1,50,array(34,5,106), true) }}" alt="Barcode Image" />
            {{-- <img class="barcode" src="data:image/png;base64,{{ DNS1D::getBarcodePNG(strtoupper($barcode), 'C39+',1,50,array(20,134,0), false) }}" alt="Barcode Image" /> --}}
            {{-- <barcode class="barcode" code="{{$barcode}}>" type="C39" size="0.8" height="2.0" /> --}}

            @endforeach
        </div>
    </div>
    @else
    <p>No barcodes available.</p>
    @endif
</body>
</html>
