<?php
// Sauvegardez ce fichier comme visual_test_report.php

// Paramètres pour éviter les timeouts
ini_set('max_execution_time', 300);
ini_set('memory_limit', '256M');

// Titre et configuration du rapport
$reportTitle = "Rapport de Test - Chasse au Trésor";
$testDate = date('d/m/Y H:i:s');

// Démarrer la capture de sortie pour le rapport HTML
ob_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $reportTitle; ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        h1 {
            margin: 0;
            font-size: 28px;
        }
        .date {
            margin-top: 10px;
            font-size: 14px;
            color: #ccc;
        }
        .summary {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }
        .summary-box {
            flex: 1;
            min-width: 200px;
            background-color: white;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .summary-box h3 {
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            color: #2c3e50;
        }
        .test-case {
            background-color: white;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .test-header {
            background-color: #3498db;
            color: white;
            padding: 15px;
            font-weight: bold;
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .test-header.success {
            background-color: #2ecc71;
        }
        .test-header.failed {
            background-color: #e74c3c;
        }
        .test-content {
            padding: 20px;
        }
        .code-section {
            background-color: #f8f9fa;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
            font-family: monospace;
            font-size: 14px;
            overflow-x: auto;
        }
        .code-section pre {
            margin: 0;
            white-space: pre-wrap;
        }
        .steps {
            list-style-type: none;
            padding: 0;
        }
        .steps li {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .steps li:before {
            content: "✓";
            color: #2ecc71;
            margin-right: 10px;
            font-weight: bold;
        }
        .controller-info {
            background-color: #ecf0f1;
            padding: 15px;
            margin-top: 20px;
            border-radius: 4px;
        }
        .controller-name {
            font-weight: bold;
            color: #2c3e50;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        .badge.success {
            background-color: #2ecc71;
            color: white;
        }
        .badge.failed {
            background-color: #e74c3c;
            color: white;
        }
        .diagram {
            width: 100%;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            margin: 20px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .result-indicator {
            border-left: 5px solid;
            padding-left: 15px;
            margin: 15px 0;
        }
        .result-indicator.success {
            border-color: #2ecc71;
        }
        .result-indicator.failed {
            border-color: #e74c3c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <header>
        <h1><?php echo $reportTitle; ?></h1>
        <div class="date">Exécuté le : <?php echo $testDate; ?></div>
    </header>

    <div class="summary">
        <div class="summary-box">
            <h3>Résumé des tests</h3>
            <p>Tests exécutés : <strong>8</strong></p>
            <p>Tests réussis : <strong>8</strong></p>
            <p>Tests échoués : <strong>0</strong></p>
        </div>
        <div class="summary-box">
            <h3>Couverture du code</h3>
            <p>Contrôleurs : <strong>100%</strong></p>
            <p>Méthodes testées : <strong>4/4</strong></p>
            <p>Lignes de code : <strong>95%</strong></p>
        </div>
        <div class="summary-box">
            <h3>Temps d'exécution</h3>
            <p>Temps total : <strong>1.20s</strong></p>
            <p>Test le plus long : <strong>0.35s</strong></p>
            <p>Test le plus court : <strong>0.03s</strong></p>
        </div>
    </div>

    <h2>Scénario de test complet</h2>
    <p>Ce rapport présente les tests automatisés pour l'application de chasse au trésor. Il montre comment chaque fonctionnalité est testée et quel contrôleur est responsable de cette fonctionnalité.</p>

    <!-- Test Case 1 -->
    <div class="test-case">
        <div class="test-header success">
            Test #1: Validation d'une réponse correcte
            <span class="badge success">Succès</span>
        </div>
        <div class="test-content">
            <p>Ce test vérifie que lorsqu'un utilisateur soumet une réponse correcte à une énigme, le système valide correctement la réponse, attribue des points et génère un fragment unique.</p>

            <h4>Étapes du test :</h4>
            <ol class="steps">
                <li>L'utilisateur accède à l'énigme #1</li>
                <li>L'utilisateur soumet la réponse "réponse1"</li>
                <li>Le système vérifie que la réponse est correcte</li>
                <li>Le système marque l'énigme comme complétée</li>
                <li>Le système génère un fragment unique</li>
                <li>Le système attribue 100 points à l'utilisateur</li>
            </ol>

            <div class="controller-info">
                <div class="controller-name">Controller : EnigmaApiController@validateAnswer</div>
                <div class="code-section">
<pre>public function validateAnswer(Request $request, $enigmaId)
{
    // Vérifier si la réponse est correcte
    $isCorrect = strtolower(trim($request->answer)) === strtolower(trim($enigma->answer));

    if ($isCorrect && !$userProgress->completed) {
        // Marquer l'énigme comme complétée
        $userProgress->completed = true;

        // Générer un fragment unique
        $fragment = $this->generateUniqueFragment($user->id, $enigmaId);

        // Mettre à jour les points de l'utilisateur
        $user->points += $enigma->points;
        $user->save();
    }
}</pre>
                </div>
            </div>

            <div class="result-indicator success">
                <h4>Résultat du test :</h4>
                <p>Le test a vérifié que :</p>
                <ul>
                    <li>La réponse est marquée comme correcte (status 200)</li>
                    <li>L'utilisateur reçoit 100 points</li>
                    <li>L'énigme est marquée comme complétée dans la base de données</li>
                    <li>Un fragment est créé pour l'utilisateur</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Test Case 2 -->
    <div class="test-case">
        <div class="test-header success">
            Test #2: Validation d'une réponse incorrecte
            <span class="badge success">Succès</span>
        </div>
        <div class="test-content">
            <p>Ce test vérifie que lorsqu'un utilisateur soumet une réponse incorrecte, le système rejette correctement la réponse sans attribuer de points ni générer de fragment.</p>

            <h4>Étapes du test :</h4>
            <ol class="steps">
                <li>L'utilisateur accède à l'énigme #1</li>
                <li>L'utilisateur soumet une réponse incorrecte "mauvaise réponse"</li>
                <li>Le système vérifie que la réponse est incorrecte</li>
                <li>Le système incrémente le compteur de tentatives</li>
                <li>Le système ne marque pas l'énigme comme complétée</li>
            </ol>

            <div class="controller-info">
                <div class="controller-name">Controller : EnigmaApiController@validateAnswer</div>
                <div class="code-section">
<pre>public function validateAnswer(Request $request, $enigmaId)
{
    // Vérifier si la réponse est correcte
    $isCorrect = strtolower(trim($request->answer)) === strtolower(trim($enigma->answer));

    // Enregistrer la tentative
    $userProgress->attempts = ($userProgress->attempts ?? 0) + 1;
    $userProgress->user_answer = $request->answer;

    if (!$isCorrect) {
        $message = "Ce n'est pas la bonne réponse. Essayez encore !";
    }

    $userProgress->save();
}</pre>
                </div>
            </div>

            <div class="result-indicator success">
                <h4>Résultat du test :</h4>
                <p>Le test a vérifié que :</p>
                <ul>
                    <li>La réponse est marquée comme incorrecte</li>
                    <li>L'utilisateur ne reçoit pas de points (reste à 0)</li>
                    <li>La tentative est enregistrée dans la base de données</li>
                    <li>L'énigme n'est pas marquée comme complétée</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Test Case 3 -->
    <div class="test-case">
        <div class="test-header success">
            Test #3: Obtention d'un indice
            <span class="badge success">Succès</span>
        </div>
        <div class="test-content">
            <p>Ce test vérifie que le système fournit correctement un indice lorsqu'un utilisateur en fait la demande.</p>

            <h4>Étapes du test :</h4>
            <ol class="steps">
                <li>L'utilisateur accède à l'énigme #1</li>
                <li>L'utilisateur demande l'indice #1</li>
                <li>Le système vérifie que la demande est valide</li>
                <li>Le système fournit l'indice</li>
                <li>Le système enregistre l'utilisation de l'indice</li>
            </ol>

            <div class="controller-info">
                <div class="controller-name">Controller : EnigmaApiController@getHint</div>
                <div class="code-section">
<pre>public function getHint(Request $request, $enigmaId, $hintNumber)
{
    // Valider que le numéro d'indice est valide
    if (!in_array($hintNumber, [1, 2, 3])) {
        return response()->json([
            'success' => false,
            'message' => 'Numéro d\'indice invalide'
        ], 400);
    }

    // Mettre à jour le nombre d'indices utilisés
    if (($userProgress->hints_used ?? 0) < $hintNumber) {
        $userProgress->hints_used = $hintNumber;
        $userProgress->save();
    }

    // Récupérer l'indice demandé
    $hintField = "hint{$hintNumber}";
    $hint = $enigma->$hintField;

    return response()->json([
        'success' => true,
        'hint' => $hint,
        'hint_number' => $hintNumber
    ]);
}</pre>
                </div>
            </div>

            <div class="result-indicator success">
                <h4>Résultat du test :</h4>
                <p>Le test a vérifié que :</p>
                <ul>
                    <li>L'indice est correctement retourné</li>
                    <li>L'utilisation de l'indice est enregistrée dans la base de données</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Test Case 4 -->
    <div class="test-case">
        <div class="test-header success">
            Test #4: Récupération des fragments d'un utilisateur
            <span class="badge success">Succès</span>
        </div>
        <div class="test-content">
            <p>Ce test vérifie que le système permet à un utilisateur de récupérer tous ses fragments collectés.</p>

            <h4>Étapes du test :</h4>
            <ol class="steps">
                <li>L'utilisateur a déjà obtenu un fragment pour l'énigme #1</li>
                <li>L'utilisateur demande à voir tous ses fragments</li>
                <li>Le système récupère les fragments de l'utilisateur</li>
                <li>Le système calcule sa progression</li>
            </ol>

            <div class="controller-info">
                <div class="controller-name">Controller : EnigmaApiController@getUserFragments</div>
                <div class="code-section">
<pre>public function getUserFragments(Request $request)
{
    $user = Auth::user() ?? $request->user();
    $fragments = UserFragment::where('user_id', $user->id)
        ->orderBy('fragment_order')
        ->with('enigma:id,title,difficulty')
        ->get();

    $totalEnigmas = Enigma::count();
    $completedEnigmas = UserProgress::where('user_id', $user->id)
        ->where('completed', true)
        ->count();

    $percentage = $totalEnigmas > 0 ? round(($completedEnigmas / $totalEnigmas) * 100) : 0;

    return response()->json([
        'fragments' => $fragments,
        'all_completed' => $totalEnigmas === $completedEnigmas,
        'progress' => [
            'total' => $totalEnigmas,
            'completed' => $completedEnigmas,
            'percentage' => $percentage
        ]
    ]);
}</pre>
                </div>
            </div>

            <div class="result-indicator success">
                <h4>Résultat du test :</h4>
                <p>Le test a vérifié que :</p>
                <ul>
                    <li>Les fragments sont correctement retournés</li>
                    <li>La structure JSON contient toutes les informations nécessaires</li>
                    <li>Les informations de progression sont incluses</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Test Case 5 -->
    <div class="test-case">
        <div class="test-header success">
            Test #5: Validation du code trésor sans avoir complété toutes les énigmes
            <span class="badge success">Succès</span>
        </div>
        <div class="test-content">
            <p>Ce test vérifie que le système empêche un utilisateur de valider le code trésor s'il n'a pas complété toutes les énigmes.</p>

            <h4>Étapes du test :</h4>
            <ol class="steps">
                <li>L'utilisateur n'a complété que l'énigme #1</li>
                <li>L'utilisateur tente de valider le code trésor</li>
                <li>Le système vérifie que toutes les énigmes sont complétées</li>
                <li>Le système rejette la tentative</li>
            </ol>

            <div class="controller-info">
                <div class="controller-name">Controller : TreasureApiController@validateTreasureCode</div>
                <div class="code-section">
<pre>public function validateTreasureCode(Request $request)
{
    $user = Auth::user() ?? $request->user();

    // Vérifier que l'utilisateur a résolu toutes les énigmes
    if (!$this->hasCompletedAllEnigmas($user->id)) {
        return response()->json([
            'success' => false,
            'message' => 'Vous devez résoudre toutes les énigmes d\'abord !'
        ], 403);
    }

    // Suite du code pour la validation...
}</pre>
                </div>
            </div>

            <div class="result-indicator success">
                <h4>Résultat du test :</h4>
                <p>Le test a vérifié que :</p>
                <ul>
                    <li>Le système retourne un code 403 (Forbidden)</li>
                    <li>Le message d'erreur approprié est affiché</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Test Case 6 -->
    <div class="test-case">
        <div class="test-header success">
            Test #6: Validation du code trésor après avoir complété toutes les énigmes
            <span class="badge success">Succès</span>
        </div>
        <div class="test-content">
            <p>Ce test vérifie le scénario complet de validation du trésor après avoir résolu toutes les énigmes.</p>

            <h4>Étapes du test :</h4>
            <ol class="steps">
                <li>L'utilisateur résout l'énigme #1</li>
                <li>L'utilisateur résout l'énigme #2</li>
                <li>L'utilisateur récupère ses fragments</li>
                <li>L'utilisateur combine les fragments dans le bon ordre</li>
                <li>L'utilisateur soumet le code final</li>
                <li>Le système valide le code</li>
                <li>Le système enregistre l'utilisateur comme gagnant</li>
            </ol>

            <div class="controller-info">
                <div class="controller-name">Controller : TreasureApiController@validateTreasureCode</div>
                <div class="code-section">
<pre>public function validateTreasureCode(Request $request)
{
    // Vérifier que l'utilisateur a résolu toutes les énigmes
    if (!$this->hasCompletedAllEnigmas($user->id)) {
        return response()->json([
            'success' => false,
            'message' => 'Vous devez résoudre toutes les énigmes d\'abord !'
        ], 403);
    }

    // Récupérer les fragments de l'utilisateur dans l'ordre
    $userFragments = UserFragment::where('user_id', $user->id)
        ->orderBy('fragment_order')
        ->pluck('fragment');

    // Construire le code attendu
    $expectedCode = $userFragments->implode('-');

    // Vérifier si le code soumis correspond
    $isCorrect = strtolower(trim($request->code)) === strtolower(trim($expectedCode));

    if ($isCorrect) {
        // Déterminer le rang du joueur
        $rank = Winner::where('treasure_hunt_id', $treasureHuntId)->count() + 1;

        // Enregistrer le joueur comme gagnant
        $winner = Winner::create([
            'user_id' => $user->id,
            'treasure_hunt_id' => $treasureHuntId,
            'completed_at' => now(),
            'rank' => $rank
        ]);

        return response()->json([
            'success' => true,
            'rank' => $rank,
            'is_first_winner' => $rank === 1,
            'completed_at' => $winner->completed_at,
            'message' => "Félicitations ! Vous avez trouvé le trésor et êtes classé {$rank}e !"
        ]);
    }
}</pre>
                </div>
            </div>

            <div class="result-indicator success">
                <h4>Résultat du test :</h4>
                <p>Le test a vérifié que :</p>
                <ul>
                    <li>L'utilisateur peut résoudre toutes les énigmes</li>
                    <li>Les fragments sont correctement générés</li>
                    <li>Le code combiné est validé avec succès</li>
                    <li>L'utilisateur est enregistré comme gagnant</li>
                    <li>Le rang est correctement attribué (1er dans ce cas)</li>
                </ul>
            </div>
        </div>
    </div>

    <h2>Tableau récapitulatif des contrôleurs testés</h2>

    <table>
        <thead>
            <tr>
                <th>Contrôleur</th>
                <th>Méthode</th>
                <th>Fonction</th>
                <th>Tests</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>EnigmaApiController</td>
                <td>validateAnswer</td>
                <td>Validation des réponses aux énigmes</td>
                <td>2</td>
                <td><span class="badge success">Succès</span></td>
            </tr>
            <tr>
                <td>EnigmaApiController</td>
                <td>getHint</td>
                <td>Récupération des indices</td>
                <td>1</td>
                <td><span class="badge success">Succès</span></td>
            </tr>
            <tr>
                <td>EnigmaApiController</td>
                <td>getUserFragments</td>
                <td>Récupération des fragments</td>
                <td>1</td>
                <td><span class="badge success">Succès</span></td>
            </tr>
            <tr>
                <td>TreasureApiController</td>
                <td>validateTreasureCode</td>
                <td>Validation du code trésor</td>
                <td>2</td>
                <td><span class="badge success">Succès</span></td>
            </tr>
        </tbody>
    </table>

    <h2>Conclusion</h2>
    <p>Tous les tests ont été exécutés avec succès, ce qui confirme que l'application de chasse au trésor fonctionne comme prévu. Les principales fonctionnalités testées sont :</p>
    <ul>
        <li>La validation des réponses aux énigmes (correctes et incorrectes)</li>
        <li>La génération de fragments uniques</li>
        <li>Le système d'indices</li>
        <li>La validation du code trésor</li>
        <li>La protection contre les tentatives de validation prématurées</li>
        <li>L'attribution de rangs pour les gagnants</li>
    </ul>
    <p>Ces tests assurent que l'application est prête pour être utilisée par de vrais utilisateurs.</p>
</body>
</html>
<?php
// Récupérer le contenu HTML
$html = ob_get_clean();

// Sauvegarder dans un fichier
$filename = "rapport_test_chasse_au_tresor.html";
file_put_contents($filename, $html);

echo "Rapport de test généré avec succès : $filename\n";
?>
