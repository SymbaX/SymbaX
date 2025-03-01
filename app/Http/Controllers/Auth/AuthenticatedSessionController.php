<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\UseCases\Auth\AuthSessionUseCase;

/**
 * 認証セッションコントローラークラス
 *
 * このクラスは、認証セッションに関連する操作を提供します。
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * 認証セッションのビジネスロジックを提供するユースケース
     * 
     * @var AuthSessionUseCase 認証セッションに使用するUseCaseインスタンス
     */
    private $authSessionUseCase;

    /**
     * AuthenticatedSessionControllerのコンストラクタ
     * 
     * 使用するユースケースをインジェクション（注入）します。
     *
     * @param AuthSessionUseCase $authSessionUseCase 認証セッションのユースケース
     */
    public function __construct(AuthSessionUseCase $authSessionUseCase)
    {
        $this->authSessionUseCase = $authSessionUseCase;
    }

    /* =================== 以下メインの処理 =================== */

    /**
     * ログイン画面を表示するメソッド
     *
     * @return View ログイン画面のViewインスタンス
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * ログイン処理を行うメソッド
     *
     * @param LoginRequest $request ログインリクエスト
     * @return RedirectResponse リダイレクトレスポンス
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // リクエストからemailとpasswordのみを取得して、$credentialsに代入する
        $credentials = $request->only('email', 'password');

        // $credentialsを使用してログイン処理を試みる
        // ログイン処理が成功した場合、RouteServiceProvider::HOMEにリダイレクトする
        if ($this->authSessionUseCase->processLogin($credentials)) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // ログイン処理が失敗した場合、エラーメッセージと共にログイン画面にリダイレクトする
        return back()->withErrors([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * ログアウト処理を行うメソッド
     *
     * @return RedirectResponse リダイレクトレスポンス
     */
    public function destroy(): RedirectResponse
    {
        // ログアウト処理を行う
        $this->authSessionUseCase->logout();

        // トップページにリダイレクトする
        return redirect('/');
    }
}
