<?php
require "helpers.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$complete_name = $_POST['complete_name'] ?? '';
$email = $_POST['email'] ?? '';
$birthdate = $_POST['birthdate'] ?? '';
$contact_number = $_POST['contact_number'] ?? '';
$answers = $_POST['answers'] ?? [];

$score = compute_score($answers);
$total_questions = MAX_QUESTION_NUMBER;

// Beyond 2 points uses is-success, otherwise is-danger
$hero_class = ($score > 2) ? 'is-success' : 'is-danger';

// Format birthdate to "Month dd, YYYY" format (e.g. "August 20, 2026")
$formatted_birthdate = (!empty($birthdate)) ? date("F d, Y", strtotime($birthdate)) : "N/A";

$questions_data = retrieve_questions();
$questions = $questions_data['questions'];
$correct_answers = $questions_data['answers'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IPT10 Quiz App - Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/confetti-js@0.0.18/site/site.min.css">
    <script src="https://cdn.jsdelivr.net/npm/confetti-js@0.0.18/dist/index.min.js"></script>
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-dark: #1d4ed8;
            --light-blue-bg: #f0f7ff;
            --border-blue: #bfdbfe;
        }
        body {
            background-color: var(--light-blue-bg);
            min-height: 100vh;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            padding-bottom: 3rem;
        }
        .hero {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .result-container {
            max-width: 860px;
            margin: 2rem auto 0 auto;
            padding: 0 1rem;
        }
        .card-box {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.06);
            border: 1px solid var(--border-blue);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .section-title {
            color: #1e293b;
            font-weight: 600;
            border-left: 4px solid var(--primary-blue);
            padding-left: 0.75rem;
            margin-bottom: 1.25rem;
        }
        .table {
            border-radius: 8px;
            overflow: hidden;
        }
        .button.is-link {
            background-color: var(--primary-blue);
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.2s ease;
        }
        .button.is-link:hover {
            background-color: var(--primary-blue-dark);
        }
        #confetti-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 999;
            pointer-events: none;
        }
    </style>
</head>
<body>

<!-- Dynamic Hero Banner based on score -->
<section class="hero <?php echo $hero_class; ?> is-bold">
    <div class="hero-body has-text-centered">
        <h1 class="title is-2">Your Score: <?php echo $score; ?> / <?php echo $total_questions; ?></h1>
        <p class="subtitle is-5">
            <?php 
                if ($score === 5) {
                    echo "🎉 Perfect Score! Excellent work!";
                } elseif ($score > 2) {
                    echo "Great job! You passed the quiz.";
                } else {
                    echo "Better luck next time!";
                }
            ?>
        </p>
    </div>
</section>

<div class="result-container">
    
    <!-- Registration Details Card -->
    <div class="card-box">
        <h2 class="title is-4 section-title">Examinee Information</h2>
        <div class="table-container">
            <table class="table is-bordered is-striped is-hoverable is-fullwidth">
                <tbody>
                    <tr>
                        <th style="width: 35%;">Input Field</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Complete Name</td>
                        <td><strong><?php echo htmlspecialchars($complete_name); ?></strong></td>
                    </tr>
                    <tr>
                        <td>Email Address</td>
                        <td><?php echo htmlspecialchars($email); ?></td>
                    </tr>
                    <tr>
                        <td>Birthdate</td>
                        <td><?php echo htmlspecialchars($formatted_birthdate); ?></td>
                    </tr>
                    <tr>
                        <td>Contact Number</td>
                        <td><?php echo htmlspecialchars($contact_number); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Questions Answer Key & User Choices Table -->
    <div class="card-box">
        <h2 class="title is-4 section-title">Detailed Answers Breakdown</h2>
        <div class="table-container">
            <table class="table is-bordered is-striped is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-background-link-light">
                        <th style="width: 5%;">#</th>
                        <th style="width: 45%;">Question</th>
                        <th style="width: 22%;">Correct Answer</th>
                        <th style="width: 20%;">Your Answer</th>
                        <th style="width: 8%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questions as $index => $q): 
                        $correct_key = $correct_answers[$index];
                        $user_key = $answers[$index] ?? null;

                        $correct_text = $correct_key;
                        $user_text = ($user_key !== null) ? $user_key : 'No Answer';

                        foreach ($q['options'] as $opt) {
                            if ($opt['key'] === $correct_key) {
                                $correct_text = $opt['key'] . '. ' . $opt['value'];
                            }
                            if ($opt['key'] === $user_key) {
                                $user_text = $opt['key'] . '. ' . $opt['value'];
                            }
                        }

                        $is_correct = ($user_key !== null && $correct_key === $user_key);
                    ?>
                    <tr>
                        <td><strong><?php echo ($index + 1); ?></strong></td>
                        <td><?php echo htmlspecialchars($q['question']); ?></td>
                        <td><span class="has-text-success font-weight-bold"><?php echo htmlspecialchars($correct_text); ?></span></td>
                        <td>
                            <?php if ($user_key === null): ?>
                                <span class="has-text-grey-light"><i>No Answer</i></span>
                            <?php else: ?>
                                <span><?php echo htmlspecialchars($user_text); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($is_correct): ?>
                                <span class="tag is-success">Correct</span>
                            <?php else: ?>
                                <span class="tag is-danger">Incorrect</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="has-text-centered mt-5">
        <a href="index.php" class="button is-link is-medium">Take Quiz Again</a>
    </div>

</div>

<!-- Confetti Canvas displayed ONLY on perfect score 5/5 -->
<?php if ($score === 5): ?>
<canvas id="confetti-canvas"></canvas>
<script>
    var confettiSettings = { target: 'confetti-canvas' };
    var confetti = new ConfettiGenerator(confettiSettings);
    confetti.render();
</script>
<?php endif; ?>

</body>
</html>