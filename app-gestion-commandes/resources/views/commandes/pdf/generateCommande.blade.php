<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details de la Commande</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        .header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        .total {
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Details de la commande #{{ $commande->id }}</h2>
    </div>

    <div>
        <h3>Détails des Produits</h3>
        <p><strong>Nom:</strong> {{ $commande->client->nom }}</p>
        <p><strong>E-mail:</strong> {{ $commande->client->email }}</p>
        <p><strong>Telephone:</strong> {{ $commande->client->telephone }}</p>
        <p><strong>Adresse:</strong> {{ $commande->client->adresse }}</p>
        <p><strong>Date de création de la commande :</strong> {{ $commande->created_at }}</p>
    </div>

    <h3>Détails des Produits</h3>

    <table>
        <thead>
            <tr>
                <th>ID produit</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Quantité</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->produits as $produit)
                <tr>
                    <td>{{ $produit->id }}</td>
                    <td>{{ $produit->nom }}</td>
                    <td>{{ $produit->prix }} DH</td>
                    <td>{{ $produit->pivot->quantite }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p><strong>Total de la commande:</strong> {{ number_format($commande->total, 2) }} DH</p>
    </div>

</body>
</html>
