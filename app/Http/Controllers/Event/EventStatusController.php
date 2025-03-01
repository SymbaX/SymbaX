<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\UseCases\Event\EventStatusUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

/**
 * イベントステータスコントローラー
 *
 * イベントへの参加ステータスに関連するアクションを提供するコントローラーです。
 */
class EventStatusController extends Controller
{
    /**
     * イベントステータス操作のビジネスロジックを提供するユースケース
     * 
     * @var EventStatusUseCase イベントステータスの操作に使用するUseCaseインスタンス
     */
    private $eventStatusUseCase;

    /**
     * EventStatusControllerのコンストラクタ
     *
     * 使用するユースケースをインジェクション（注入）します。
     *
     * @param EventStatusUseCase $eventStatusUseCase イベントステータスの操作に使用するUseCaseのインスタンス
     */
    public function __construct(EventStatusUseCase $eventStatusUseCase)
    {
        $this->eventStatusUseCase = $eventStatusUseCase;
    }

    /* =================== 以下メインの処理 =================== */

    /**
     * イベントへの参加をリクエストするメソッド
     *
     * リクエストから受け取ったデータを検証し、指定されたイベントに参加リクエストを送信します。
     *
     * @param Request $request 参加リクエストのためのリクエストデータ
     * @return RedirectResponse イベント詳細ページへのリダイレクトレスポンス
     */
    public function joinRequest(Request $request): RedirectResponse
    {
        $status = $this->eventStatusUseCase->joinRequest($request);
        $event_id = $request->input('event_id');
        return redirect()->route('event.show', ['event_id' => $event_id])->with('status', $status);
    }

    /**
     * イベントへの参加のキャンセルするメソッド
     *
     * リクエストから受け取ったデータを検証し、指定されたイベントへの参加をキャンセルします。
     *
     * @param Request $request キャンセルリクエストのためのリクエストデータ
     * @return RedirectResponse イベント詳細ページへのリダイレクトレスポンス
     */
    public function cancelJoin(Request $request): RedirectResponse
    {
        $status = $this->eventStatusUseCase->cancelJoin($request);
        $event_id = $request->input('event_id');
        return redirect()->route('event.show', ['event_id' => $event_id])->with('status', $status);
    }

    /**
     * イベントへの参加ステータスを変更するメソッド
     *
     * リクエストから受け取ったデータを検証し、指定されたイベントへの参加ステータスを変更します。
     *
     * @param Request $request ステータス変更リクエストのためのリクエストデータ
     * @return RedirectResponse イベント詳細ページへのリダイレクトレスポンス
     */
    public function changeStatus(Request $request): RedirectResponse
    {
        $status = $this->eventStatusUseCase->changeStatus($request);
        $event_id = $request->input('event_id');
        return redirect()->route('event.show', ['event_id' => $event_id])->with('status', $status);
    }
}
