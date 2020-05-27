                        <label>データ解析</label>
                        <div class="row" id="channelUpdate">
                             <div class ="row" style="margin-right:0px">
                                <button class="btn btn-primary pull-right" id="channelUpdateButton"
                                        style="margin-right:15px;margin-left:15px;background:red;border:none;" >チャンネル追加/削除</button>
                                <div class="input-group pull-right col-xs-5">
                                    <span class="input-group-addon">表示内容：</span>
                                    <select class="form-control" id="selectContent">
                                        <option value="1">1: 総数</option>
                                        <option value="2">2: 1日増加数</option>
                                    </select>
                                    <span class="input-group-addon">表示範囲：</span>
                                    <select class="form-control" id="selectDays">
                                        <option value="1">1: 7日間</option>
                                        <option value="2">2: 28日間</option>
                                        <option value="3">3: 90日間</option>
                                    </select>
                                </div>
                            </div>
                        </div><br>
                        <div class="table-responsive" id = "channelAnalytics1">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="info">
                                        <th width=50px >選択</th>
                                        <th>チャンネル名</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($result as $row2){
                                    echo '<tr>';
                                    echo "<td><div class='chkbox'><input type='checkbox' class='channelCheck' id='".$row2['chId']."'></div></td>";
                                    echo "<td>".$row2['chName']."</td>";
                                    echo '</tr>';
                                }
                                ?>
                                    <tr>
                                        <td colspan="2">
                                            <button class="pull-right" id="deleteChannel">削除</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon3">チャンネルURL：</span>
                                <input type="text" class="form-control" id="channelUrl" aria-describedby="basic-addon3">
                            </div>
                            <div class="row" style= "margin-top: 10px;margin-right: 0px;">
                                <button class="pull-right" id="channelRegister" style="margin-left:5px">登録</button>
                                <button class="pull-right" id="channelReset">キャンセル</button><!-- btn btn-primary  -->
                            </div>
                        </div>

                        <div class="row" id="channelAnalytics2">
                            <table class="table table-fixed">
                                <thead>
                                    <tr class="info">
                                        <th class="col-xs-5" >チャンネル名</th>
                                        <th class="col-xs-3" >再生回数</th>
                                        <th class="col-xs-3" >チャンネル登録者</th>
                                        <th class="col-xs-1" >解析</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($result as $row2){

                                    $chId = $row2['chId'];
                                    $stmt3 = '';
                                    $sql3 = "SELECT * FROM channelinfo WHERE chId = :chId ORDER BY date DESC LIMIT 1";
                                    $stmt3 = $pdo->prepare($sql3);
                                    $stmt3->execute(array($chId));
                                    $result3 = $stmt3->fetchAll();
                                    if(count($result3)>0){
                                        foreach ($result3 as $row3){
                                            echo '<tr>';
                                            echo "<td class = 'col-xs-5 chName'>".htmlspecialchars($row2['chName'])."</td>";
                                            echo "<td class = 'col-xs-3 viewCount'>".htmlspecialchars($row3['viewCount'])."</td>";
                                            echo "<td class = 'col-xs-3 crCount'>".htmlspecialchars($row3['crCount'])."</td>";
                                            echo "<td class = 'col-xs-1'><button class = 'anlyticsButton' id= $chId>解析</button></td>";
                                            echo '</tr>';
                                        }
                                    }else{
                                        echo '<tr>';
                                        echo "<td class = 'chName col-xs-5'>".htmlspecialchars($row2['chName'])."</td>";
                                        echo "<td class = 'viewCount col-xs-3'>0</td>";
                                        echo "<td class = 'crCount col-xs-3'>0</td>";
                                        echo "<td class = 'col-xs-1'><button class = 'anlyticsButton' id= $chId>解析</button></td>";
                                        echo '</tr>';
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            <br>
                             <div class="input-group col-xs-5">
                                <span class="input-group-addon" id="basic-addon3">チャンネル名：</span>
                                <input type="text" class="form-control" id="selectedChannelName" aria-describedby="basic-addon3">
                            </div>
                            <div id="chartContainer" style="height: 300px;"></div>
                        </div>
                