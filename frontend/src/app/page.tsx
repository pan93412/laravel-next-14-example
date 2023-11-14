export default function Home() {
  return (
    <main className="ts-container">
      <div className="ts-content">
        <table className="ts-table">
          <thead>
            <tr>
              <th>姓名</th>
              <th>地址</th>
              <th>生日</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>半音商業銀行</td>
              <td>Flat Bank</td>
            </tr>
            <tr>
              <td>2</td>
              <td>對空音商事有限公司</td>
              <td>Sorae & Co., Ltd.</td>
            </tr>
            <tr>
              <td>3</td>
              <td>卡莉絲伊繁星</td>
              <td>Caris Events</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th colSpan={3}>統計筆數：3</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </main>
  );
}
