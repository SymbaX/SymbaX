<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use App\Http\Controllers\OperationLogController;

/**
 * パスワードリセットリンクコントローラー
 *
 * パスワードリセットリンクに関連するコントローラー
 */
class PasswordResetLinkController extends Controller
{
    private $operationLogController;

    public function __construct(OperationLogController $operationLogController)
    {
        $this->operationLogController = $operationLogController;
    }


    /**
     * パスワードリセットリンクリクエストビューを表示する
     *
     * @return View パスワードリセットリンクリクエストビューの表示
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * パスワードリセットリンクリクエストの処理を行う
     *
     * @param Request $request リクエスト
     * @return RedirectResponse リダイレクトレスポンス
     *
     * @throws \Illuminate\Validation\ValidationException バリデーション例外
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // パスワードリセットリンクをこのユーザーに送信します。
        // リンクの送信を試みた後、レスポンスを検証し、ユーザーに表示するメッセージを確認します。
        // 最後に、適切なレスポンスを送信します。
        $status = Password::sendResetLink(
            $request->only('email')
        );

        $this->operationLogController->store('Email: ' . $request->email . ' のパスワードリセットリンクを送信しました', "不明");

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
