<?php
namespace App\Infrastructure;

use App\Domain\Wish;
use App\Storage\Storage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    public function indexAction()
    {
        $s = $this->render_php(PROJECT_ROOT . "/src/wishlist.php");
        $response = new Response($s);
        // Wish table
        $storage = new Storage();
        $stmt = $storage->getWishTable();
        if ($stmt->rowCount() > 0):
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
            <?php while ($row = $stmt->fetch()): ?>
                <tr>
                    <td><?=$row['wish'];?></td>
                    <td><a href="<?=$row['link'];?>"><?=$row['link'];?></a></td>
                    <td><?=$row['description'];?></td>
                </tr>
                <?php endwhile; ?>
                    </tbody>
            </table>
            <?php
            endif;
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

    private function render_php($path)
    {
        ob_start();
        include($path);
        $var = ob_get_contents();
        ob_end_clean();
        return $var;
    }
}
