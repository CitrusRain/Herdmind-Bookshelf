SELECT * FROM
(
  SELECT DISTINCT Fact.FactID, Fact.DatePosted, Fact.Contents, sum(tal.Value) as RecentSum FROM
  (
    (
      (
        (
          Fact LEFT JOIN SubmissionData AS s ON FactID = s.SubmissionID
        )
        LEFT JOIN FactScoreByTally AS tal ON Fact.FactID = tal.FactID
      )
      JOIN FactBranch AS fb ON Fact.FactID = fb.FactID
    )
    JOIN Branch AS b ON fb.BranchID = b.BranchID
  )
  WHERE b.branchid = '<% iId %>'
  AND tal.DatePointScored > DATE_SUB(curdate(), INTERVAL 2 WEEK)
  AND s.IsPublic='1'
  AND s.IsMature='<% bMature %>'
  AND s.IsRemoved='0'
  GROUP BY Fact.FactID
  ORDER BY sum(tal.Value)
  DESC LIMIT 10
) AS PopularFacts LEFT JOIN (
  SELECT DISTINCT Fact.FactID, sum(tal.Value) as TotalSum, s.ID FROM
  (
    (
      (
        (
          Fact LEFT JOIN SubmissionData AS s ON FactID = s.SubmissionID
        )
        LEFT JOIN FactScoreByTally AS tal ON Fact.FactID = tal.FactID
      )
      JOIN FactBranch AS fb ON Fact.FactID = fb.FactID
    )
    JOIN Branch AS b ON fb.BranchID = b.BranchID
  )
  WHERE b.branchid = '<% iId %>'
  AND s.IsPublic='1'
  AND s.IsMature='<% bMature %>'
  AND s.IsRemoved='0'
  GROUP BY Fact.FactID
  LIMIT 10
) AS AllTimePopularFacts ON PopularFacts.FactID = AllTimePopularFacts.FactID
ORDER BY Rand() LIMIT 10
