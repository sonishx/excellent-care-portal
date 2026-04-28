<?php

namespace App\Services;

use App\Models\ChatMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotService
{
    public function generateResponse(string $userMessage, int $userId, ?string $userRole = null): string
    {
        try {
            return $this->generateOllamaResponse($userMessage, $userId, $userRole);
        } catch (\Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage());
            return $this->generateRuleBasedResponse($userMessage);
        }
    }

    protected function generateOllamaResponse(string $userMessage, int $userId, ?string $userRole = null): string
    {
        $conversationHistory = $this->getConversationHistory($userId);

        $messages = [
            [
                'role' => 'system',
                'content' => $this->getSystemPrompt($userRole)
            ],
            ...$conversationHistory,
            [
                'role' => 'user',
                'content' => $userMessage
            ]
        ];

        $response = Http::timeout(120)->post('http://localhost:11434/api/chat', [
            'model' => 'llama3.2:1b',
            'messages' => $messages,
            'stream' => false
        ]);

        if ($response->successful()) {
            return trim($response->json('message.content')) ?: 'No response from local AI.';
        }

        Log::error('Ollama API error: ' . $response->body());
        return $this->generateRuleBasedResponse($userMessage);
    }

    protected function generateRuleBasedResponse(string $userMessage): string
    {
        $msg = strtolower($userMessage);

        if (preg_match('/patient|client|participant/i', $msg)) {
            return "You can manage patients from the 'Patients' section where all details and care plans are available.";
        }

        if (preg_match('/care plan|goal|support/i', $msg)) {
            return "Care plans help track goals and support strategies. Check the 'Care Plans' section.";
        }

        if (preg_match('/document|file|invoice|report/i', $msg)) {
            return "You can manage documents like invoices and reports in the Documents section.";
        }

        if (preg_match('/shift|schedule|roster/i', $msg)) {
            return "Your shifts and schedules are available under assigned care plans.";
        }

        if (preg_match('/help|support/i', $msg)) {
            return "I'm here to help! Ask me anything about the portal or general questions.";
        }

        if (preg_match('/hello|hi|hey/i', $msg)) {
            return "Hello! How can I assist you today?";
        }

        return "I can help with portal features or general questions. Please ask anything.";
    }

    protected function getConversationHistory(int $userId): array
    {
        $messages = ChatMessage::where('user_id', $userId)
            ->latest()
            ->limit(10)
            ->get()
            ->reverse();

        return $messages->map(function ($msg) {
            return [
                'role' => $msg->sender_type === 'user' ? 'user' : 'assistant',
                'content' => $msg->message
            ];
        })->toArray();
    }

    protected function getSystemPrompt(?string $userRole = null): string
    {
        $roleLine = $userRole ? "User role: {$userRole}." : "";

        return "You are an AI assistant for Excellent Care Services, an NDIS and Aged Care provider.
{$roleLine}
Answer clearly, professionally, and concisely.
Help users with portal questions, patients, care plans, documents, schedules, and general support.";
    }
}