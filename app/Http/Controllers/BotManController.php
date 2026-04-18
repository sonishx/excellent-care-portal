<?php
use BotMan\BotMan\BotManFactory;
use BotMan\Drivers\DriverManager;
use BotMan\Drivers\Web\WebDriver;
use Illuminate\Http\Request;

class BotManController extends Controller
{
    public function handle(Request $request)
    {
        // Load the Web driver
        DriverManager::loadDriver(WebDriver::class);

        $botman = BotManFactory::create([], []);

        $userMessage = $request->input('message');

        $reply = $this->getBotReply($userMessage);

        return response()->json(['message' => $reply]);
    }

    private function getBotReply($message)
    {
        $msg = strtolower($message);

        if (str_contains($msg, 'invoice')) {
            return "Sure! Please provide the invoice number or date.";
        }

        if (str_contains($msg, 'shift')) {
            return "You can view all your shifts under the 'Patients' or 'Care Plans' section.";
        }

        if (str_contains($msg, 'care plan')) {
            return "I can help you with care plans. Which patient do you want to view?";
        }

        return "Hi! Can you clarify your request?";
    }
}
?>