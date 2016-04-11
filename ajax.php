<?

//$input = "Help me (random|randomize) this sentece by (shuffling|(trying to shuffle|making it (random|more random))) on each (iteration|iterations|iterationz)";

function randomVariant($textVariantsList)
{
    // checking if we have some nested variant lists
    // on current iteration

    preg_match('/\((.*)\)/', $textVariantsList, $matches);

    if (isset($matches[1])) {

        // some nested variants lists found!
        // We need to change all the | to ! in it

        $tmpInput = str_replace($matches[1], str_replace('|', '!', $matches[1]), $textVariantsList);
        $variants = explode('|', $tmpInput);

        // puttin' all delimiters back

        return str_replace('!', '|', $variants[rand(0, count($variants) - 1)]);

    }

    // no nested lists found,
    // so we can return random variant

    $variants = explode('|', $textVariantsList);

    return $variants[rand(0, count($variants) - 1)];

}

function parseRecursive($input)
{
    $regex = '/\(((?:[^()]|(?R))+)\)/';

    if (is_array($input)) {

        $input = randomVariant($input[1]);
    }

    return preg_replace_callback($regex, 'parseRecursive', $input);
}

$input = $_POST['input'];

$output = parseRecursive($input);

echo $output;




