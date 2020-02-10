<?php
namespace App\Infrastructure;

use App\Domain\Wish;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    public function indexAction()
    {
        $response = new Response(
            (string)file_get_contents(PROJECT_ROOT . "/src/index.html"));
        // Wish table
        $table = Wish::getTable();
        if (count($table) > 0) {
            ?>
            <h2>Список желаний:</h2>
            <table border="1">
                <thead>
                <tr>
                    <td>Желание</td>
                    <td>Ссылка</td>
                    <td>Дополнительная информация</td>
                </tr>
                </thead>
                <tbody>
            <?php
            foreach ($table as $wish) {
                ?>
                <tr>
                    <td><?=$wish->getWish();?></td>
                    <td><a href="<?=$wish->getLink();?>"><?=$wish->getLink();?></a></td>
                    <td><?=$wish->getDescription();?></td>
                </tr>
                <?php
            }
        }
        ?>
            </tbody>
        </table>
        <?php
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }

    public function addWishAction(Request $request)
    {
        try {
            $wish = new Wish(
                $request->request->get('wish'),
                $request->request->get('link'),
                $request->request->get('description')
            );
            $wish->validate();
            $wish->saveToStorage();
            $response = new Response();
        } catch (\Exception $e) {
            $response = new Response("Error!: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
