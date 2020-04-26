

<form action="/member/signUp" method="POST">
    <table>
        <tr>
            <th>이름</th>
            <td><input type="text" name="userName" value="" /></td>
        </tr>
        <tr>
            <th>닉네임</th>
            <td><input type="text" name="nickname"" value="" /></td>
        </tr>
        <tr>
            <th>비밀번호</th>
            <td><input type="password"" name="passwd" value="" /></td>
        </tr>
        <tr>
            <th>비밀번호확인</th>
            <td><input type="password" name="passwdConfirm" value="" /></td>
        </tr>
        <tr>
            <th>전화번호</th>
            <td><input type="text" name="phone" value="" /></td>
        </tr>
        <tr>
            <th>email</th>
            <td><input type="text" name="email" value="" /></td>
        </tr>
        <tr>
            <th>성별</th>
            <td><input type="text" name="gender" value="" /></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="저장" />
            </td>
        </tr>
    </table>

</form>

<br />

<form action="/member/login" method="POST">
    <table>
    <tr>
            <th>email</th>
            <td><input type="text" name="email" value="" /></td>
        </tr>
        <tr>
            <th>비밀번호</th>
            <td><input type="password"" name="passwd" value="" /></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Login" />
            </td>
        </tr>
        

    </table>

</form>
